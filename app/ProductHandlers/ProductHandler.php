<?php

namespace App\ProductHandlers;

use App\Models\Product;

interface ProductHandler
{
    public static function crawl(Product $product): ProductDetails;
}
