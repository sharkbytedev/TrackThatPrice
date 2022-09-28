<?php

namespace App\ProductHandlers;

use App\Models\Product;
use Goutte\Client;
use InvalidArgumentException;


class WalmartHandler extends ProductHandler {
    protected $url_base = [
        "https://www.walmart.ca",
        "https://www.walmart.com"
    ];
    public const store_name = "walmart";

    public static function fromDbModel(Product $product): ProductHandler
    {
        return new WalmartHandler($product->product_url, $product);
    }

    public function update(bool $update_db = false): array {
        $client = new Client();
        $client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36');
        $website = $client->request('GET', $this->product_url);

        try {
            // Most disinguishing feature for tags on the Walmart are these data-automiation properties
            $this->name = $website->filter('h1[data-automation="product-title"]')->eq(0)->text();
            $price_text = $website->filter('span[data-automation="buybox-price"]')->eq(0)->text();
            $this->price = floatval(trim($price_text, "$"));

            $this->image_url = $website->filter('#main-image')->filter('img')->eq(0)->attr('src');
        } catch (InvalidArgumentException $e) {
            return [false, $e];
        }

        $this->last_updated = new \DateTime();

        if (isset($this->_obj)) {
            $this->_obj->last_status_code = $client->getResponse()->getStatusCode();
            $this->_update_db_model($update_db);
        }

        // No errors were caught, so return true
        return [true, ''];
    }
}