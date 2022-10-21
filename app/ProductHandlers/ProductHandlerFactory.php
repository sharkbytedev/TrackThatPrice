<?php

namespace App\ProductHandlers;

use App\Models\Product;

class ProductHandlerFactory
{
    public static function new(Product $product): ProductHandler
    {
        switch ($product->store) {
            case 'amazon':
                return new AmazonHandler();
                break;
            case 'ebay':
                return new EbayHandler();
                break;
            default:
                return null;
        }
    }
}
