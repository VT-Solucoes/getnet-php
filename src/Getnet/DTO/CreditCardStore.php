<?php

namespace Getnet\DTO;

class CreditCardStore extends CreditCard
{
    /**
     * @var string
     */
    public string $customer_id;

    /**
     * @var string
     */
    public string $cardholder_identification;

    /**
     * @var bool
     */
    public bool $verify_card;

    /**
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->customer_id;
    }

    /**
     * @param string $customer_id
     * @return CreditCardStore
     */
    public function setCustomerId(string $customer_id): CreditCardStore
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getCardholderIdentification(): string
    {
        return $this->cardholder_identification;
    }

    /**
     * @param string $cardholder_identification
     * @return CreditCardStore
     */
    public function setCardholderIdentification(string $cardholder_identification): CreditCardStore
    {
        $this->cardholder_identification = $cardholder_identification;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVerifyCard(): bool
    {
        return $this->verify_card;
    }

    /**
     * @param bool $verify_card
     * @return CreditCardStore
     */
    public function setVerifyCard(bool $verify_card): CreditCardStore
    {
        $this->verify_card = $verify_card;

        return $this;
    }
}
