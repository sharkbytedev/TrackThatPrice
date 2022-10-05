<?php

namespace App\ProductHandlers;

class ProductDetails
{
    public int $price;

    public string $name;

    public string $image_url;

    public string $product_url;

    public int $status_code;

    public function get_as_json(): string
    {
        return json_encode([
            'name' => $this->name,
            'price' => $this->price,
            'product_url' => $this->product_url,
            'image_url' => $this->image_url,
            'status_code' => $this->status_code,
        ]);
    }
}
