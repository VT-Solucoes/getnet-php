<?php

namespace Getnet\DTO;

use Getnet\DTO\Interfaces\ToJsonInterface;
use Getnet\DTO\Traits\ToJsonTrait;

class CreditCardTokenizer implements ToJsonInterface
{
    use ToJsonTrait;

    /**
     * @var string
     */
    private string $card_number;

    /**
     * @var string
     */
    private string $customer_id;

    /**
     * @return string
     */
    public function getCardNumber(): string
    {
        return $this->card_number;
    }

    /**
     * @param string $card_number
     * @return CreditCardTokenizer
     */
    public function setCardNumber(string $card_number): CreditCardTokenizer
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
     * @return CreditCardTokenizer
     */
    public function setCustomerId(string $customer_id): CreditCardTokenizer
    {
        $this->customer_id = $customer_id;
        return $this;
    }
}
