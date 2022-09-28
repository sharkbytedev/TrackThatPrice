<?php

use App\Http\Controllers\ScraperController;
use App\ProductHandlers\AmazonHandler;
use App\ProductHandlers\WalmartHandler;
use App\Models\Product;

$p = new WalmartHandler("https://www.walmart.ca/en/ip/sony-srsxb13b-xb13-extra-bass-compact-bluetooth-speaker-black-black/6000202817704");
dump($p->update());
$p->createDbEntry();
$p->update(true);
dump($p);
// $p = Product::all()[1];
// $h = AmazonHandler::fromDbModel($p);
// $h->update(true);
// dump($h);



// dump(ScraperController::index()->filter("img")->attr("src"));
// echo ScraperController::index();
?>