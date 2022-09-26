<?php

namespace Getnet\API;

use Getnet\DTO\Traits\ToJsonTrait;

/**
 * Class Transaction
 *
 * @package Getnet\API
 */
class Transaction implements \JsonSerializable
{
    use ToJsonTrait;

    const STATUS_AUTHORIZED = "AUTHORIZED";
    const STATUS_CONFIRMED = "CONFIRMED";
    const STATUS_PENDING = "PENDING";
    const STATUS_APPROVED = "APPROVED";
    const STATUS_CANCELED = "CANCELED";
    const STATUS_DENIED = "DENIED";
    const STATUS_ERROR = "ERROR";

    private $seller_id;

    private $amount;

    private string $currency = "BRL";

    private Order $order;

    private Customer $customer;

    private Device $device;

    private $shippings;

    private Credit $credit;

    private Credit $debit;

    private Boleto $boleto;

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
    public function setSellerId($seller_id): Transaction
    {
        $this->seller_id = (string)$seller_id;

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
    public function setAmount($amount): Transaction
    {
        $this->amount = (int)($amount * 100);

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Transaction
     */
    public function setCurrency(string $currency): Transaction
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     *
     * @param $order_id
     * @return Order
     */
    public function order($order_id): Order
    {
        $order = new Order($order_id);
        $this->setOrder($order);

        return $order;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return Transaction
     */
    public function setOrder(Order $order): Transaction
    {
        $this->order = $order;

        return $this;
    }

    /**
     *
     * @param mixed $id
     * @return Customer
     */
    public function customer($id = null): Customer
    {
        $customer = new Customer($id);

        $this->setCustomer($customer);

        return $customer;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return Transaction
     */
    public function setCustomer(Customer $customer): Transaction
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     *
     * @param mixed $device_id
     * @return Device
     */
    public function device($device_id): Device
    {
        $device = new Device($device_id);

        $this->device = $device;

        return $device;
    }

    /**
     * @return Device
     */
    public function getDevice(): Device
    {
        return $this->device;
    }

    /**
     * @param Device $device
     * @return Transaction
     */
    public function setDevice(Device $device): Transaction
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippings()
    {
        return $this->shippings;
    }

    /**
     * @param array $shippings
     * @return Transaction
     */
    public function setShippings(array $shippings): Transaction
    {
        $this->shippings = $shippings;

        return $this;
    }

    /**
     *
     * @return Shipping
     */
    public function shipping(): Shipping
    {
        $shipping = new Shipping();

        $this->addShipping($shipping);

        return $shipping;
    }

    /**
     *
     * @param Shipping $shipping
     */
    public function addShipping(Shipping $shipping)
    {
        if (!is_array($this->shippings)) {
            $this->shippings = array();
        }

        $this->shippings[] = $shipping;
    }

    /**
     *
     * @param Customer $customer
     * @return Shipping
     */
    public function addShippingByCustomer(Customer $customer): Shipping
    {
        $shipping = new Shipping();

        $this->addShipping($shipping->populateByCustomer($customer));

        return $shipping;
    }

    /**
     *
     * @param $brand
     * @return Credit
     */
    public function credit($brand = null): Credit
    {
        $credit = new Credit($brand);
        $this->setCredit($credit);

        return $credit;
    }

    /**
     * @return Credit
     */
    public function getCredit(): Credit
    {
        return $this->credit;
    }

    /**
     * @param Credit $credit
     * @return Transaction
     */
    public function setCredit(Credit $credit): Transaction
    {
        $this->credit = $credit;

        return $this;
    }

    /**
     * @param $brand
     * @return Credit
     */
    public function debit($brand): Credit
    {
        $debit = new Credit($brand);

        $this->setDebit($debit);

        return $debit;
    }

    /**
     * @return Credit
     */
    public function getDebit(): Credit
    {
        return $this->debit;
    }

    /**
     * @param Credit $debit
     * @return Transaction
     */
    public function setDebit(Credit $debit): Transaction
    {
        $this->debit = $debit;

        return $this;
    }

    /**
     *
     * @param $our_number
     * @return Boleto
     */
    public function boleto($our_number): Boleto
    {
        $boleto = new Boleto($our_number);
        $this->boleto = $boleto;

        return $boleto;
    }

    /**
     * @return Boleto
     */
    public function getBoleto(): Boleto
    {
        return $this->boleto;
    }

    /**
     * @param Boleto $boleto
     * @return Transaction
     */
    public function setBoleto(Boleto $boleto): Transaction
    {
        $this->boleto = $boleto;

        return $this;
    }
}