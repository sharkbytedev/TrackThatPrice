<?php

namespace App\ProductHandlers;

use App\Models\Product;

class ProductDetails
{
    public int $price;

    public string $name;

    public string $image_url;

    public string $product_url;

    public int $status_code;

    public static function from_db_entry(Product $p): ProductDetails
    {
        $details = new ProductDetails();
        $details->price = $p->price;
        $details->name = $p->product_name;
        $details->image_url = $p->image_url;
        $details->product_url = $p->product_url;
        $details->status_code = $p->last_status_code;

        return $details;
    }

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
