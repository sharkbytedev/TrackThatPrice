<?php

namespace App\ProductHandlers;

use App\Models\Product;
use Goutte\Client;
use InvalidArgumentException;

class EbayHandler extends ProductHandler
{
    public const store_name = 'ebay';

    protected $url_base = [
        'https://www.ebay.ca/',
        'https://www.ebay.com/',

    ];

    public static function from_db_model(Product $product): ProductHandler
    {
        return new EbayHandler($product->product_url, $product);
    }

    public function update(bool $update_db = false): array
    {
        $client = new Client();
        $client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36');
        $website = $client->request('GET', $this->product_url);
        try {
            $this->name = $website->filter('h1[class="x-item-title__mainTitle"] > span')->eq(0)->text();
            $price_text = explode('$', $website->filter('#prcIsum')->eq(0)->text());
            $this->price = floatval(end($price_text));

            // On ebay, the image element is created by a short bit of js that contains the image source
            $img_script_text = $website->filter('#mainImgHldr > script')->eq(0)->text();

            // Regex to match the image URL from the text of the script
            $url_pattern = '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#';
            $matches = [];
            preg_match($url_pattern, $img_script_text, $matches);
            $this->image_url = $matches[0];

            // An InvalidArgumentException means one of the properties(name, price, etc.) could not be found
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
