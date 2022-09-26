<?php

namespace Getnet\API;

use Exception;
use Getnet\DTO\Interfaces\ToJsonInterface;
use Getnet\DTO\Traits\ToJsonTrait;
use JsonSerializable;

/**
 * Class Subscriptions
 *
 * @package Getnet\API
 */
class Subscriptions implements JsonSerializable, ToJsonInterface
{
    use ToJsonTrait;

    private $subscription_id;
    private $status_details;
    private $payment;

    /**
     * Get the value of subscription_id
     */
    public function getSubscriptionId()
    {
        return $this->subscription_id;
    }

    /**
     * Set the value of subscription_id
     *
     * @param $subscription_id
     * @return  self
     */
    public function setSubscriptionId($subscription_id): Subscriptions
    {
        $this->subscription_id = $subscription_id;

        return $this;
    }

    /**
     * Get the value of status_details
     */
    public function getStatusDetails()
    {
        return $this->status_details;
    }

    /**
     * Set the value of status_details
     *
     * @param $status_details
     * @return self
     */
    public function setStatusDetails($status_details): Subscriptions
    {
        $this->status_details = $status_details;

        return $this;
    }

    /**
     * Get the value of payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set the value of payment
     *
     * @return  self
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Cria nova assinatura
     *
     * @throws Exception
     */
    public function newSubscription(Getnet $credencial, $data): Subscriptions
    {
        $request = new Request($credencial);
        $response = $request->post($credencial, "/v1/subscriptions", json_encode($data));

        $this->setSubscriptionId($response['subscription']['subscription_id']);
        $this->setStatusDetails($response['status_details']);
        $this->setPayment($response['payment']);

        return $this;
    }

    /**
     * Alterar valor da assinatura
     *
     * @throws Exception
     */
    public function addAmountSubscription(Getnet $credencial, $idSubscription, $data)
    {
        $request = new Request($credencial);

        return $request->post($credencial, "/v1/subscriptions/$idSubscription/floating", json_encode([$data]));
    }

    /**
     * Alterar valor da assinatura
     *
     * @throws Exception
     */
    public function changeAmountSubscription(Getnet $credencial, $idSubscription, $data)
    {
        $request = new Request($credencial);

        return $request->patch($credencial, "/v1/subscriptions/$idSubscription/floating", json_encode([$data]));
    }

    /**
     * Alterar valor da assinatura
     *
     * @throws Exception
     */
    public function removeAllFloating(Getnet $credencial, $idSubscription)
    {
        $request = new Request($credencial);

        return $request->delete($credencial, "/v1/subscriptions/$idSubscription/floating");
    }

    /**
     * Alterar dia da assinatura
     *
     * @throws Exception
     */
    public function changeDaySubscription(Getnet $credencial, $idSubscription, $data)
    {
        $request = new Request($credencial);

        return $request->patch($credencial, "/v1/subscriptions/$idSubscription/paymentDate", json_encode($data));
    }


    /**
     * Alterar valor da assinatura
     *
     * @throws Exception
     */
    public function getSubscription(Getnet $credencial, $idSubscription)
    {
        $request = new Request($credencial);

        return $request->get($credencial, "/v1/subscriptions/$idSubscription");
    }

    /**
     * Listar ultimas 6 assinaturas
     *
     * @throws Exception
     */
    public function getSubscriptions(Getnet $credencial, $query)
    {
        $q = http_build_query($query);
        $request = new Request($credencial);

        return $request->get($credencial, "/v1/charges?$q");
    }
}
