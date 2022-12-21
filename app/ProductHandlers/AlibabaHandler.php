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

class AmazonHandler implements ProductHandler
{
    const base_url = [
        'https://www.alibaba.com/',
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

    protected string $product_url;

    public static function crawl(Product $product): ProductDetails
    {
        $client = new Client();
        $client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36');
        $website = $client->request('GET', $product->product_url);
        EbayHandler::handleStatusCode($client->getResponse()->getStatusCode());

        $details = new ProductDetails();
        //
        $details->name = $website->filter('div[class="product-title"]')->eq(0)->text();
        //On Alibaba, price is formatted as (currency)$123.45, so i filter out the non-numbers
        $price_text = $website->filter('div[class="price-item"]')->eq(1)->eq(0)->attr('content');
        for(int i = 0; i < $price_text->count(); i++){
            if(preg_match("/[^0-9]/", $price_text[i])){
                $pricePos = i;
                break;
            }
        }
        $details->price = substr($price_text, $pricePos);
        $details->currency = substr($price_text, 0, $pricePos); 

        $details->store_id = explode('/', parse_url($product->product_url, PHP_URL_PATH))[2];

        try {
            $upc = $website->filter('span[itemprop="gtin13"] > div > span')->eq(0)->text();
            $details->upc = $upc;
        } catch (InvalidArgumentException $e) {
            Log::notice('UPC not found for product', ['product_id' => $product->id, 'error' => $e]);
            $details->upc = '';
        }
        // No errors were caught, so return true
        return $details;
    }
}