<?php

namespace App\ProductHandlers;

use Illuminate\Http\Request;
use Goutte\Client;

use App\ProductHandlers\ProductHandler;
use InvalidArgumentException;

class AmazonHandler extends ProductHandler {
    public const store_name = "amazon";
    protected $url_base = [
        "https://www.amazon.ca/",
        "https://www.amazon.com/",

    ];

    function __construct(string $url)
    {
        $valid = false;
        // Check if the url has a valid base for this store
        foreach ($this->url_base as $u) {
            if (str_starts_with($url, $u)) {
                $valid = true;
                break;
            }
        }
        if (!$valid) {
            throw new \Exception("'$url' has an invalid base");
        }
        $this->product_url = $url;

    }
    // TODO: Add error checking
    function _update(): Array
    {
        $client = new Client();
        $client->setServerParameter("HTTP_USER_AGENT", "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36");
        $website = $client->request("GET", $this->product_url);
        
        try {
            // Gets the text of the first div with the id #productTitle
            $this->name = $website->filter("#productTitle")->eq(0)->text();
            // On amazon, the price is divided into 3 parts: Symbol, whole, and fraction
            $price_whole = $website->filter(".a-price-whole")->eq(0)->text();
            $price_fraction = $website->filter(".a-price-fraction")->eq(0)->text();
            $this->price = floatval($price_whole.$price_fraction);
        
            // Get an image url. Often on Amazon there's more than one, so we'll just get the first one.
            $this->image_url = $website->filter("#imgTagWrapperId")->filter("img")->eq(0)->attr("src");
        }
        catch (InvalidArgumentException $e) {
            return [false, $e];
        }
        $this->last_updated = new \DateTime();

        // No errors were caught, so return true
        return [true, ""];
    }
}