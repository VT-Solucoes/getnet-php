<?php

namespace Getnet\DTO\Traits;

trait ToJsonTrait
{
    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return json_encode(
            array_filter(
                $this->toArray(),
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

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(
            function ($item) {
                if (is_object($item)) {
                    return $item->toArray();
                }
                if (is_array($item)) {
                    foreach ($item as $key => $value) {
                        $item[$key] = $value->toArray();
                    }
                }

                return $item;
            },
            get_object_vars($this)
        );
    }
}
