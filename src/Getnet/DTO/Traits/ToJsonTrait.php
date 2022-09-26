<?php

namespace Getnet\DTO\Traits;

/**
 *
 */
trait ToJsonTrait
{
    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return json_encode(
            array_filter(
                get_object_vars($this),
                fn($value) => null !== $value
            )
        );
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return $this->jsonSerialize();
    }
}
