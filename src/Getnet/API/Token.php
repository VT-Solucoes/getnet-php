<?php

namespace Getnet\API;

use Exception;
use Getnet\Exceptions\InvalidArgumentException;

/**
 * Class Token
 *
 * @package Getnet\API
 */
class Token
{
    /**
     * @var string
     */
    private string $number_token;

    /**
     * @var string
     */
    private string $card_number;

    /**
     * @var string
     */
    private string $customer_id;

    /**
     * @var Getnet
     */
    private Getnet $getnet;

    /**
     * @return string
     */
    public function getNumberToken(): string
    {
        return $this->number_token;
    }

    /**
     * @param string $number_token
     * @return Token
     */
    public function setNumberToken(string $number_token): Token
    {
        $this->number_token = $number_token;

        return $this;
    }

    /**
     * @return string
     */
    public function getCardNumber(): string
    {
        return $this->card_number;
    }

    /**
     * @param string $card_number
     * @return Token
     */
    public function setCardNumber(string $card_number): Token
    {
        $this->card_number = $card_number;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->customer_id;
    }

    /**
     * @param string $customer_id
     * @return Token
     */
    public function setCustomerId(string $customer_id): Token
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    /**
     * @return Getnet
     */
    public function getGetnet(): Getnet
    {
        return $this->getnet;
    }

    /**
     * @param Getnet $getnet
     * @return Token
     */
    public function setGetnet(Getnet $getnet): Token
    {
        $this->getnet = $getnet;

        return $this;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function requestANewToken(): void
    {
        if (empty($this->getnet)) {
            throw new InvalidArgumentException('O cliente GetNet nao foi informado.');
        }

        if (empty($this->card_number) || empty($this->customer_id)) {
            throw new InvalidArgumentException(
                'O número do cartão e a identificação do cliente precisam ser informados.'
            );
        }

        $data = [
            "card_number" => $this->card_number,
            "customer_id" => $this->customer_id
        ];

        $request = new Request($this->getnet);
        $response = $request->post($this->getnet, "/v1/tokens/card", json_encode($data));

        $this->number_token = $response["number_token"];
    }

    /**
     * @return string
     * @throws Exception
     */
    public function __toString()
    {
        if ($this->number_token) {
            return $this->number_token;
        }

        $this->requestANewToken();

        return $this->number_token;
    }
}