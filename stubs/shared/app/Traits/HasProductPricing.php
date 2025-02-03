<?php

declare(strict_types=1);

namespace App\Traits;

use App\DTO\PriceData;
use Shopper\Core\Helpers\Price;

trait HasProductPricing
{
    public function getPrice(): ?PriceData
    {
        $currencyCode = current_currency();

        $price = $this->loadMissing('prices', 'prices.currency')
            ->prices
            ->reject(fn ($price) => $price->currency->code !== $currencyCode)
            ->first();

        return $price
            ? new PriceData(
                value: Price::from($price->amount, $currencyCode),
                compare: $price->compare_amount ? Price::from($price->compare_amount, $currencyCode) : null,
                percentage: $price->compare_amount > 0
                    ? round((($price->compare_amount - $price->amount) / $price->compare_amount) * 100)
                    : null
            )
            : null;
    }
}
