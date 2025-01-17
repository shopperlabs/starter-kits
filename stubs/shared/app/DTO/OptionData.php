<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Support\Collection;
use Shopper\Core\Models\Attribute;

class OptionData
{
    public function __construct(
        public Attribute $attribute,
        public Collection $values,
    ) {}
}
