<?php

namespace App\ProductHandlers;

use App\Models\Product;
use InvalidArgumentException;

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
            case 'alibaba':
                return new AlibabaHandler();
            default:
                throw new InvalidArgumentException("'$product->store' is not a supported store name");
        }
    }
}
