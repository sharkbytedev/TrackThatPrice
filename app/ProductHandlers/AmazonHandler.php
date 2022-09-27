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

    public function __construct(string $url, Product $product = null)
    {
        if (isset($product) && $product->store != $this::store_name) {
            throw new \Exception('Store must be amazon');
        }
        $valid = false;
        // Check if the url has a valid base for this store
        foreach ($this->url_base as $u) {
            if (str_starts_with($url, $u)) {
                $valid = true;
                break;
            }
        }
        if (! $valid) {
            throw new \Exception("'$url' has an invalid base");
        }
        $this->product_url = $url;

        if ($product) {
            $this->_obj = $product;
            $this->name = $product->product_name;
            $this->image_url = $product->image_url;
            $this->last_updated = $product->last_queried;
            $this->price = $product->price;
        }
    }

    public static function fromDbModel(Product $product): ProductHandler
    {
        return new AmazonHandler($product->product_url, $product);
    }

    public function update(bool $update_db = false): array
    {
        $client = new Client();
        $client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36');
        $website = $client->request('GET', $this->product_url);

        try {
            // Gets the text of the first div with the id #productTitle
            $this->name = $website->filter('#productTitle')->eq(0)->text();
            // On amazon, the price is divided into 3 parts: Symbol, whole, and fraction
            $price_whole = $website->filter('.a-price-whole')->eq(0)->text();
            $price_fraction = $website->filter('.a-price-fraction')->eq(0)->text();
            $this->price = floatval($price_whole.$price_fraction);

            // Get an image url. Often on Amazon there's more than one, so we'll just get the first one.
            $this->image_url = $website->filter('#imgTagWrapperId')->filter('img')->eq(0)->attr('src');
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
