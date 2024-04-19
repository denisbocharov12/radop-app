<?php

namespace App\Services;

abstract class ToBooleanService
{
    public function toBoolean(mixed $value): ?bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
