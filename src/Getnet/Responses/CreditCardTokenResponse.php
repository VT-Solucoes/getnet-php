<?php

namespace Getnet\Responses;

class CreditCardTokenResponse extends BaseResponse
{
    public string $number_token;

    /**
     * @return string
     */
    public function getNumberToken(): string
    {
        return $this->number_token;
    }

    /**
     * @param string $number_token
     * @return CreditCardTokenResponse
     */
    public function setNumberToken(string $number_token): CreditCardTokenResponse
    {
        $this->number_token = $number_token;

        return $this;
    }
}
