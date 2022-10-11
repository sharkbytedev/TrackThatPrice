<?php

namespace App\ProductHandlers;

use App\Models\Product;
use Goutte\Client;
use InvalidArgumentException;
use App\Exceptions\QueryExceptions\{NotFoundError, ServerError, BadRequestError, GoneError, QueryException};

class AmazonHandler implements ProductHandler
{
    const base_url = [
        'https://www.amazon.ca/',
        'https://www.amazon.com/',
    ];

    protected static function handleStatusCode(int $code) {
        switch ($code) {
            case 200:
                break;
            case 500:
                throw new ServerError("Server responded with 500");
                break;
            case 404:
                throw new NotFoundError("Server responded with 404");
                break;
            case 410:
                throw new GoneError("Server responded with 410");
            case 400:
                throw new BadRequestError("Server responded with 500");
                break;
            default:
                throw new QueryException("Server responded with non-200 status code $code");
                break;
        }
    }

    protected string $product_url;

    public static function crawl(Product $product): ProductDetails
    {
        $url = $product->product_url;
        $client = new Client();
        $client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36');
        $website = $client->request('GET', $url);
        AmazonHandler::handleStatusCode($client->getResponse()->getStatusCode());

        $details = new ProductDetails();

        // Gets the text of the first div with the id #productTitle
        $details->name = $website->filter('#productTitle')->eq(0)->text();
        // On amazon, the price is divided into 3 parts: Symbol, whole, and fraction
        $price_whole = $website->filter('.a-price-whole')->eq(0)->text();
        $price_fraction = $website->filter('.a-price-fraction')->eq(0)->text();
        // Store price in cents, so multiply price by 100
        $details->price = floatval($price_whole.$price_fraction) * 100;

        try {
            // Get an image url. Often on Amazon there's more than one, so we'll just get the first one.
            $details->image_url = $website->filter('#imgTagWrapperId')->filter('img')->eq(0)->attr('src');
        }
        catch (InvalidArgumentException $e) {
            $details->image_url = null;
        }

        return $details;
    }
}
