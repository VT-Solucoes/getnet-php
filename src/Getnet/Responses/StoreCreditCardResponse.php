<?php

namespace Getnet\Responses;

/**
 *
 */
class StoreCreditCardResponse extends BaseResponse
{
    /**
     * @var string
     */
    public string $card_id;

    /**
     * @var string
     */
    public string $number_token;

    /**
     * @return string
     */
    public function getCardId(): string
    {
        return $this->card_id;
    }

    /**
     * @param string $card_id
     * @return StoreCreditCardResponse
     */
    public function setCardId(string $card_id): StoreCreditCardResponse
    {
        $this->card_id = $card_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumberToken(): string
    {
        return $this->number_token;
    }

    /**
     * @param string $number_token
     * @return StoreCreditCardResponse
     */
    public function setNumberToken(string $number_token): StoreCreditCardResponse
    {
        $this->number_token = $number_token;
        return $this;
    }
}
