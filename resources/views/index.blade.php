<?php

use App\Http\Controllers\ScraperController;
use App\ProductHandlers\AmazonHandler;
use App\Models\Product;

$p = new AmazonHandler("https://www.amazon.ca/Adafruit-Capacitive-Touch-HAT-Raspberry/dp/B00SOXX6SS/ref=sr_1_5");
dump($p->update());
$p->createDbEntry();
$p->update(true);

// $p = Product::all()[0];
// $h = AmazonHandler::fromDbModel($p);
// $h->update(true);
// dump($h)

// dump(ScraperController::index()->filter("img")->attr("src"));
// echo ScraperController::index();
?>