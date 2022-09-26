<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class ScraperController extends Controller
{
    public static function index() {
        $client = new Client();
        $client->setServerParameter("HTTP_USER_AGENT", "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36");
        $url = "https://www.amazon.ca/Adafruit-Capacitive-Touch-HAT-Raspberry/dp/B00SOXX6SS/ref=sr_1_5";
        $website = $client->request("GET", $url);
        return $website->filter("#imgTagWrapperId");
        // return $website->html();
    }
}