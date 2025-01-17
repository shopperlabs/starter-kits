<?php

declare(strict_types=1);

namespace App\DTO;

class CheckoutSessionData
{
    public function __construct(
        public AddressData $shippingAddress,
        public ?AddressData $billingAddress,
        public bool $sameAsShipping,
        public string $email,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            shippingAddress: AddressData::fromArray(data_get($data, 'shipping_address')),
            billingAddress: data_get($data, 'billing_address')
                ? AddressData::fromArray(data_get($data, 'billing_address'))
                : null,
            sameAsShipping: data_get($data, 'same_as_shipping'),
            email: data_get($data, 'email'),
        );
    }
}
