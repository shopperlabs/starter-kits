<?php

declare(strict_types=1);

namespace App\DTO;

use Shopper\Core\Helpers\Price;

class PriceData
{
    public function __construct(
        public Price $value,
        public ?Price $compare,
        public ?float $percentage,
    ) {}
}
