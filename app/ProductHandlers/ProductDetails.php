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
        $details->status_code = $p->last_status_code;

        return $details;
    }
}
