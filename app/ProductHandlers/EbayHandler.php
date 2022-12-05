<?php

namespace App\ProductHandlers;

use App\Exceptions\QueryExceptions\BadRequestError;
use App\Exceptions\QueryExceptions\GoneError;
use App\Exceptions\QueryExceptions\NotFoundError;
use App\Exceptions\QueryExceptions\QueryException;
use App\Exceptions\QueryExceptions\ServerError;
use App\Models\Product;
use Goutte\Client;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class EbayHandler implements ProductHandler
{
    public const store_name = 'ebay';

    protected $url_base = [
        'https://www.ebay.ca/',
        'https://www.ebay.com/',

    ];

    protected static function handleStatusCode(int $code)
    {
        switch ($code) {
            case 200:
                break;
            case 500:
                throw new ServerError('Server responded with 500');
                break;
            case 404:
                throw new NotFoundError('Server responded with 404');
                break;
            case 410:
                throw new GoneError('Server responded with 410');
            case 400:
                throw new BadRequestError('Server responded with 500');
                break;
            default:
                throw new QueryException("Server responded with non-200 status code $code");
                break;
        }
    }

    public static function crawl(Product $product): ProductDetails
    {
        $client = new Client();
        $client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36');
        $website = $client->request('GET', $product->product_url);
        EbayHandler::handleStatusCode($client->getResponse()->getStatusCode());

        $details = new ProductDetails();
        $details->name = $website->filter('h1[class="x-item-title__mainTitle"] > span')->eq(0)->text();
        // $price_text = str_replace(',', '', explode('$', $website->filter('#prcIsum')->eq(0)->text()));
        $price_text = $website->filter('span[itemprop="price"]')->eq(0)->attr('content');
        $details->price = floatval($price_text) * 100;
        $details->currency = explode(' ', $website->filter('span[itemprop="price"] > span[class="ux-textspans"]')->eq(0)->text())[0];
        $details->store_id = explode('/', parse_url($product->product_url, PHP_URL_PATH))[2];

        try {
            $upc = $website->filter('span[itemprop="gtin13"] > div > span')->eq(0)->text();
            $details->upc = $upc;
        } catch (InvalidArgumentException $e) {
            Log::notice('UPC not found for product', ['product_id' => $product->id, 'error' => $e]);
            $details->upc = '';
        }

        // On ebay, the image element is created by a short bit of js that contains the image source
        $img_script_text = $website->filter('#mainImgHldr > script')->eq(0)->text();

        // Regex to match the image URL from the text of the script
        $url_pattern = '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#';
        $matches = [];
        preg_match($url_pattern, $img_script_text, $matches);
        $details->image_url = $matches[0];

        // No errors were caught, so return true
        return $details;
    }
}
