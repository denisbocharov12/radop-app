<?php

declare(strict_types=1);

namespace App\Casts;

use Cknow\Money\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MoneyCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array<mixed, mixed>  $attributes
     * @return float
     */
    public function get($model, string $key, $value, array $attributes): float
    {
        return (float) Money::MDL($value, true)->formatByDecimal();
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array<mixed, mixed>  $attributes
     * @return string
     */
    public function set($model, string $key, $value, array $attributes): string
    {
        return (string)$value;
        //return bcmul((string) $value, '1');
    }
}
