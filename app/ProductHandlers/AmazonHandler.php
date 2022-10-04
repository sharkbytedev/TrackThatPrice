<?php

namespace App\ProductHandlers;

use App\Models\Product;
use Goutte\Client;
use InvalidArgumentException;

class AmazonHandler extends ProductHandler
{
    public const store_name = 'amazon';

    protected $url_base = [
        'https://www.amazon.ca/',
        'https://www.amazon.com/',

    ];

    public static function from_db_model(Product $product): ProductHandler
    {
        return new AmazonHandler($product->product_url, $product);
    }

    public function update(): HandlerUpdateDetails
    {
        $client = new Client();
        $client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36');
        $website = $client->request('GET', $this->product_url);
        $this->last_status_code = $client->getResponse()->getStatusCode();
        try {
            // Gets the text of the first div with the id #productTitle
            $this->name = $website->filter('#productTitle')->eq(0)->text();
            // On amazon, the price is divided into 3 parts: Symbol, whole, and fraction
            $price_whole = $website->filter('.a-price-whole')->eq(0)->text();
            $price_fraction = $website->filter('.a-price-fraction')->eq(0)->text();
            // Store price in cents, so multiply price by 100
            $this->price = floatval($price_whole.$price_fraction) * 100;

            // Get an image url. Often on Amazon there's more than one, so we'll just get the first one.
            $this->image_url = $website->filter('#imgTagWrapperId')->filter('img')->eq(0)->attr('src');
        } catch (InvalidArgumentException $e) {
            return new HandlerUpdateDetails(false, $e);
        }

        // No errors were caught, so return true
        return new HandlerUpdateDetails(true);
    }
}
