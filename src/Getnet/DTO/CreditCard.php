<?php

namespace Getnet\DTO;

use Getnet\DTO\Interfaces\ToJsonInterface;
use Getnet\DTO\Traits\ToJsonTrait;


class CreditCard implements ToJsonInterface
{
    use ToJsonTrait;

    /**
     * @var string
     */
    private string $number_token;

    /**
     * @var string
     */
    private string $brand;

    /**
     * @var string
     */
    private string $cardholder_name;

    /**
     * @var string
     */
    private string $expiration_month;

    /**
     * @var string
     */
    private string $expiration_year;

    /**
     * @var string
     */
    private string $security_code;

    /**
     * @return string
     */
    public function getNumberToken(): string
    {
        return $this->number_token;
    }

    /**
     * @param string $number_token
     * @return static
     */
    public function setNumberToken(string $number_token): CreditCard
    {
        $this->number_token = $number_token;

        return $this;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     * @return static
     */
    public function setBrand(string $brand): CreditCard
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string
     */
    public function getCardholderName(): string
    {
        return $this->cardholder_name;
    }

    /**
     * @param string $cardholder_name
     * @return static
     */
    public function setCardholderName(string $cardholder_name): CreditCard
    {
        $this->cardholder_name = $cardholder_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getExpirationMonth(): string
    {
        return $this->expiration_month;
    }

    /**
     * @param string $expiration_month
     * @return static
     */
    public function setExpirationMonth(string $expiration_month): CreditCard
    {
        $this->expiration_month = $expiration_month;

        return $this;
    }

    /**
     * @return string
     */
    public function getExpirationYear(): string
    {
        return $this->expiration_year;
    }

    /**
     * @param string $expiration_year
     * @return static
     */
    public function setExpirationYear(string $expiration_year): CreditCard
    {
        $this->expiration_year = $expiration_year;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecurityCode(): string
    {
        return $this->security_code;
    }

    /**
     * @param string $security_code
     * @return static
     */
    public function setSecurityCode(string $security_code): CreditCard
    {
        $this->security_code = $security_code;

        return $this;
    }
}
