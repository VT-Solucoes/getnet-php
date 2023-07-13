<?php

namespace Getnet\API;

use Exception;
use Getnet\DTO\CreditCardStore;
use Getnet\DTO\CreditCardTokenizer;
use Getnet\DTO\Interfaces\ToJsonInterface;
use Getnet\Exceptions\HttpException;
use Getnet\Exceptions\InvalidArgumentException;
use Getnet\Responses\AuthorizeResponse;
use Getnet\Responses\BaseResponse;
use Getnet\Responses\BoletoResponse;
use Getnet\Responses\CreditCardTokenResponse;
use Getnet\Responses\PixResponse;
use Getnet\Responses\StoreCreditCardResponse;

/**
 * Class Getnet
 *
 * @package Getnet\API
 */
class Getnet
{

    private string $client_id;

    private string $client_secret;

    private $seller_id;

    private Environment $environment;

    private ?string $authorizationToken = null;

    private string $keySession;
// TODO add monolog
    private $debug = false;

    /**
     * @param mixed $client_id
     * @param mixed $client_secret
     * @param Environment|null $environment
     * @param null $keySession
     * @throws Exception
     */
    public function __construct($client_id, $client_secret, Environment $environment = null, $keySession = null)
    {
        if (! $environment) {
            $environment = Environment::production();
        }

        $this->setClientId($client_id);
        $this->setClientSecret($client_secret);
        $this->setEnvironment($environment);
        $this->setKeySession($keySession ?? md5(rand()));

        $request = new Request($this);

        $request->auth($this);
    }

    /**
     *
     * @return string
     */
    public function getClientId()
   : string
    {
        return $this->client_id;
    }

    /**
     *
     * @param string $client_id
     * @return Getnet
     */
    public function setClientId(string $client_id): Getnet
    {
        $this->client_id = $client_id;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getClientSecret()
   : string
    {
        return $this->client_secret;
    }

    /**
     *
     * @param string $client_secret
     * @return Getnet
     */
    public function setClientSecret(string $client_secret): Getnet
    {
        $this->client_secret = $client_secret;

        return $this;
    }

    public function getSellerId()
    {
        return $this->seller_id;
    }

    public function setSellerId($seller_id)
    {
        $this->seller_id = (string) $seller_id;

        return $this;
    }

    /**
     *
     * @return Environment
     */
    public function getEnvironment()
   : Environment
    {
        return $this->environment;
    }

    /**
     *
     * @param Environment $environment
     * @return Getnet
     */
    public function setEnvironment(Environment $environment)
   : Getnet
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     *
     * @return null|string
     */
    public function getAuthorizationToken()
   : ?string
    {
        return $this->authorizationToken;
    }

    /**
     *
     * @param string $authorizationToken
     * @return Getnet
     */
    public function setAuthorizationToken(string $authorizationToken): Getnet
    {
        $this->authorizationToken = $authorizationToken;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getKeySession()
   : string
    {
        return $this->keySession;
    }

    /**
     *
     * @param string $keySession
     * @return Getnet
     */
    public function setKeySession(string $keySession): Getnet
    {
        $this->keySession = $keySession;

        return $this;
    }

    /**
     ** @return bool|null
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     *
     * @param bool|null $debug
     */
    public function setDebug($debug = false)
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     *
     * @param Transaction $transaction
     * @return BaseResponse|AuthorizeResponse
     */
    public function authorize(Transaction $transaction)
    {
        try {
            $request = new Request($this);

            if ($transaction->getCredit()) {
                $response = $request->post($this, "/v1/payments/credit", $transaction->toJson());
            } elseif ($transaction->getDebit()) {
                $response = $request->post($this, "/v1/payments/debit", $transaction->toJson());
            } else {
                throw new InvalidArgumentException("Error select credit or debit");
            }
        } catch (Exception $e) {
            $error = new BaseResponse();
            $error->mapperJson(json_decode($e->getMessage(), true));

            return $error;
        }

        $authResponse = new AuthorizeResponse();
        $authResponse->mapperJson($response);

        return $authResponse;
    }

    /**
     * @param mixed $payment_id
     * @return BaseResponse|AuthorizeResponse
     */
    public function authorizeConfirm($payment_id, $amount)
    {
        $bodyParams = array(
            'amount' => $amount
        );
        try {
            if ($this->debug) {
                print json_encode($bodyParams);
            }

            $request = new Request($this);
            $response = $request->post($this, "/v1/payments/credit/" . $payment_id . "/confirm", "");
        } catch (Exception $e) {

            $error = new BaseResponse();
            $error->mapperJson(json_decode($e->getMessage(), true));

            return $error;
        }

        $authResponse = new AuthorizeResponse();
        $authResponse->mapperJson($response);

        return $authResponse;
    }

    /**
     *
     * @param mixed $payment_id
     * @param mixed $payer_authentication_response
     * @return BaseResponse|AuthorizeResponse
     */
    public function authorizeConfirmDebit($payment_id, $payer_authentication_response)
    {
        $bodyParams = array(
            "payer_authentication_response" => $payer_authentication_response
        );
        try {
            if ($this->debug) {
                print json_encode($bodyParams);
            }

            $request = new Request($this);
            $response = $request->post($this, "/v1/payments/debit/" . $payment_id . "/authenticated/finalize", json_encode($payer_authentication_response));
        } catch (Exception $e) {

            $error = new BaseResponse();
            $error->mapperJson(json_decode($e->getMessage(), true));

            return $error;
        }

        $authResponse = new AuthorizeResponse();
        $authResponse->mapperJson($response);

        return $authResponse;
    }

    /**
     * Estorna ou desfaz transações feitas no mesmo dia (D0).
     *
     * @param string $payment_id
     * @param int|string $amount_val
     * @return AuthorizeResponse|BaseResponse
     */
    public function authorizeCancel($payment_id, $amount_val)
    {
        $bodyParams = array(
            "amount" => $amount_val
        );

        try {
            if ($this->debug) {
                print json_encode($bodyParams);
            }

            $request = new Request($this);
            $response = $request->post($this, "/v1/payments/credit/" . $payment_id . "/cancel", json_encode($bodyParams));
        } catch (Exception $e) {

            $error = new BaseResponse();
            $error->mapperJson(json_decode($e->getMessage(), true));

            return $error;
        }

        $authResponse = new AuthorizeResponse();
        $authResponse->mapperJson($response);

        return $authResponse;
    }

    /**
     * Solicita o cancelamento de transações que foram realizadas há mais de 1 dia (D+n).
     *
     * @param mixed $payment_id
     * @param mixed $cancel_amount
     * @param mixed $cancel_custom_key
     * @return AuthorizeResponse|BaseResponse
     */
    public function requestCancelTransaction($payment_id, $cancel_amount, $cancel_custom_key)
    {
        $bodyParams = array(
            "payment_id" => $payment_id,
            "cancel_amount" => $cancel_amount,
            "cancel_custom_key" => $cancel_custom_key
        );

        try {
            if ($this->debug) {
                print json_encode($bodyParams);
            }

            $request = new Request($this);
            $response = $request->post($this, "/v1/payments/cancel/request", json_encode($bodyParams));
        } catch (Exception $e) {

            $error = new BaseResponse();
            $error->mapperJson(json_decode($e->getMessage(), true));

            return $error;
        }

        $authResponse = new AuthorizeResponse();
        $authResponse->mapperJson($response);

        return $authResponse;
    }

    /**
     *
     * @param Transaction $transaction
     * @return BaseResponse|BoletoResponse
     */
    public function boleto(Transaction $transaction)
    {
        try {
            if ($this->debug) {
                print $transaction->toJSON();
            }

            $request = new Request($this);
            $response = $request->post($this, "/v1/payments/boleto", $transaction->toJson());
        } catch (Exception $e) {
            $error = new BaseResponse();
            $error->mapperJson(json_decode($e->getMessage(), true));

            return $error;
        }

        $boletoResponse = new BoletoResponse();
        $boletoResponse->mapperJson($response);
        $boletoResponse->setBaseUrl($request->getBaseUrl());
        $boletoResponse->generateLinks();

        return $boletoResponse;
    }

    /**
     * Executa a requisição para a API
     *
     * @param string $method
     * @param string $path
     * @param ToJsonInterface $toJson
     * @return array|BaseResponse|mixed
     * @throws HttpException
     */
    protected function request(string $method, string $path, ToJsonInterface $toJson)
    {
        try {
            $request = new Request($this);

            return $request->{$method}($this, $path, $toJson->toJson());
        } catch (Exception $e) {
            $baseResponse = new BaseResponse();
            $baseResponse->mapperJson(json_decode($e->getMessage(), true));

            throw new HttpException($baseResponse->error_message);
        }
    }

    /**
     * @param CreditCardTokenizer $creditCardTokenizer
     * @return CreditCardTokenResponse
     * @throws HttpException
     */
    public function requestCardToken(CreditCardTokenizer $creditCardTokenizer): CreditCardTokenResponse
    {
        $safeResponse = new CreditCardTokenResponse();
        $safeResponse->mapperJson(
            $this->request('post', "/v1/tokens/card", $creditCardTokenizer)
        );

        return $safeResponse;
    }

    /**
     * @param CreditCardStore $creditCard
     * @return StoreCreditCardResponse
     * @throws HttpException
     */
    public function requestStoreCreditCard(CreditCardStore $creditCard): StoreCreditCardResponse
    {
        $safeResponse = new StoreCreditCardResponse();
        $safeResponse->mapperJson(
            $this->request('post', "/v1/cards", $creditCard)
        );

        return $safeResponse;
    }

    /**
     * Payment confirmation is sent via notifications
     *
     * @param PixTransaction $pix
     * @return BaseResponse|PixResponse
     * @link https://developers.getnet.com.br/api#tag/Notificacoes-1.0
     */
    public function pix(PixTransaction $pix)
    {
        try {
            if ($this->debug) {
                print $pix->toJSON();
            }

            $request = new Request($this);
            $response = $request->post($this, "/v1/payments/qrcode/pix", $pix->toJSON());

            $pixResponse = new PixResponse();
            // Add fields do not return in response
            $pixResponse->mapperJson($pix->toArray());
            // Add response fields
            $pixResponse->mapperJson($response);

            return $pixResponse;
        } catch (\Exception $e) {
            return $this->generateErrorResponse($e);
        }
    }

    /**
     *
     * @param \Exception $e
     * @return \Getnet\Responses\BaseResponse
     */
    private function generateErrorResponse($e)
    {
        $error = new BaseResponse();
        $error->mapperJson(json_decode($e->getMessage(), true));

        if (empty($error->getStatus())) {
            $error->setStatus(Transaction::STATUS_ERROR);
        }

        return $error;
    }
}
