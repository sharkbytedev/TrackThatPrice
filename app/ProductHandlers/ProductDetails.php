<?php

namespace App\ProductHandlers;

class ProductDetails
{
    public int $price;

    public string $name;

    public string $image_url;

    public ?string $store_id;

    public ?string $currency;

    public ?string $upc = null;
}
