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

class AlibabaHandler implements ProductHandler
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
        AlibabaHandler::handleStatusCode($client->getResponse()->getStatusCode());

        $details = new ProductDetails();
        
        $details->name = $website->filter('.product-title')->eq(0)->eq(0)->text();
        $rawDetails = $website->filter('head > script:nth-child(52)')->eq(0)->text();
        $decodedDetails = json_decode($rawDetails);
        $details->image_url = $decodedDetails[0]->image;

        $rawPrice = $website->filter('.price-item')->filter('.price')->eq(0)->text();
        $priceCharsToRemove = array("$", ".", ",");
        $details->price = str_replace($priceCharsToRemove, "", $rawPrice);
        $details->currency = "US$"; //when the scraper grabs the information from alibaba, it automatically sets the currency to US dollar

        $details->store_id = explode('/', parse_url($product->product_url, PHP_URL_PATH))[2];

        $details->upc = '';
        
        return $details;
    }
}