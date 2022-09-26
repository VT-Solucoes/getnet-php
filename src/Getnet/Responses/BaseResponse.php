<?php

namespace Getnet\Responses;

use Getnet\API\Transaction;
use Getnet\DTO\Interfaces\ToJsonInterface;
use Getnet\DTO\Traits\ToJsonTrait;
use JsonSerializable;

/**
 * Class BaseResponse
 *
 * @package Getnet\API
 */
class BaseResponse implements JsonSerializable, ToJsonInterface
{
    use ToJsonTrait;

    public $payment_id;

    public $seller_id;

    public $amount;

    public $currency;

    public $order_id;

    public ?string $status = null;

    public $received_at;

    public $error_message;

    public ?string $description = null;

    public $description_detail;

    public $status_code;

    public $responseJson;

    public string $status_label;

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * @param mixed $error_message
     * @return BaseResponse
     */
    public function setErrorMessage($error_message): BaseResponse
    {
        $this->error_message = $error_message;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * @param mixed $status_code
     * @return BaseResponse
     */
    public function setStatusCode($status_code): BaseResponse
    {
        $this->status_code = $status_code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescriptionDetail()
    {
        return $this->description_detail;
    }

    /**
     * @param mixed $description_detail
     * @return BaseResponse
     */
    public function setDescriptionDetail($description_detail): BaseResponse
    {
        $this->description_detail = $description_detail;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getErrorDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return BaseResponse
     */
    public function setErrorDescription($description): BaseResponse
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentId()
    {
        return $this->payment_id;
    }

    /**
     * @param mixed $payment_id
     */
    public function setPaymentId($payment_id): BaseResponse
    {
        $this->payment_id = $payment_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSellerId()
    {
        return $this->seller_id;
    }

    /**
     * @param mixed $seller_id
     */
    public function setSellerId($seller_id): BaseResponse
    {
        $this->seller_id = $seller_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): BaseResponse
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency): BaseResponse
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     */
    public function setOrderId($order_id): BaseResponse
    {
        $this->order_id = $order_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        if ($this->status_code == 201) {
            $this->status = Transaction::STATUS_AUTHORIZED;
        } elseif ($this->status_code == 202) {
            $this->status = Transaction::STATUS_AUTHORIZED;
        } elseif ($this->status_code == 402) {
            $this->status = Transaction::STATUS_DENIED;
        } elseif ($this->status_code == 400) {
            $this->status = Transaction::STATUS_ERROR;
        } elseif ($this->status_code == 500) {
            $this->status = Transaction::STATUS_ERROR;
        } elseif (isset($this->redirect_url)) {
            $this->status = Transaction::STATUS_PENDING;
        } elseif (isset($this->status_label)) {
            $this->status = $this->status_label;
        }

        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): BaseResponse
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReceivedAt()
    {
        return $this->received_at;
    }

    /**
     * @param mixed $received_at
     */
    public function setReceivedAt($received_at): BaseResponse
    {
        $this->received_at = $received_at;

        return $this;
    }

    /**
     * @param array $json
     * @return $this
     */
    public function mapperJson(array $json): BaseResponse
    {
        array_walk_recursive(
            $json,
            function ($value, $key) {
                if ($key == 'info') {
                    $key = 'description';
                }
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        );

        $this->setResponseJson($json);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponseJson()
    {
        return $this->responseJson;
    }

    /**
     * @param mixed $array
     */
    public function setResponseJson($array): BaseResponse
    {
        $this->responseJson = json_encode($array);

        return $this;
    }
}
