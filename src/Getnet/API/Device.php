<?php

namespace Getnet\API;

use Getnet\DTO\Interfaces\ToJsonInterface;
use Getnet\DTO\Traits\ToJsonTrait;
use JsonSerializable;

/**
 * Class Device
 *
 * @package Getnet\API
 */
class Device implements JsonSerializable, ToJsonInterface
{
    use ToJsonTrait;

    private $device_id;

    private $ip_address;


    /**
     *
     * @param mixed $device_id
     */
    public function __construct($device_id)
    {
        $this->device_id = $device_id;
    }

    /**
     * @return mixed
     */
    public function getDeviceId()
    {
        return $this->device_id;
    }

    /**
     * @param mixed $device_id
     */
    public function setDeviceId($device_id)
    {
        $this->device_id = (string)$device_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * @param mixed $ip_address
     */
    public function setIpAddress($ip_address)
    {
        $this->ip_address = (string)$ip_address;

        return $this;
    }

}