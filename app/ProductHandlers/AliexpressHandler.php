<?php

namespace App\ProductHandlers;

use App\Exceptions\QueryExceptions\BadRequestError;
use App\Exceptions\QueryExceptions\GoneError;
use App\Exceptions\QueryExceptions\NotFoundError;
use App\Exceptions\QueryExceptions\QueryException;
use App\Exceptions\QueryExceptions\ServerError;
use App\Models\Product;
use Goutte\Client;
use App\Utils\PuppetLoad;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;


class AliexpressHandler implements ProductHandler 
{
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
        $url = $product->product_url;
        $website = PuppetLoad::load([$product->product_url])[$product->product_url];
        
        if (is_numeric($website)) {
            AliexpressHandler::handleStatusCode($website);
        }

        $website = new Crawler($website);
        $details = new ProductDetails();

        $details->name = $website->filter('div.product-info > div.product-title > h1')->eq(0)->text();
        $price_string = '';
        try {
            $price_string = $website->filter('.uniform-banner-box-price')->eq(0)->text();
            
        } catch (InvalidArgumentException $e) {
            $price_string = $website->filter('.product-price-value')->eq(0)->text();
        }

        if (str_starts_with($price_string, 'C$ ')) {
            $details->currency = 'CAD';
        }
        elseif (str_starts_with($price_string, 'US ')) {
            $details->currency = 'USD';
        }
        elseif (str_starts_with($price_string, '￡')) {
            $details->currency = 'GBP';
        }
        elseif (str_starts_with($price_string, '€ ')) {
            $details->currency = 'EUR';
        }

        $details->price = intval(floatval(explode(' ', $price_string)[1])*100);
        $details->image_url = $website->filter('img.magnifier-image')->eq(0)->attr('src');

        return $details;

    }
}