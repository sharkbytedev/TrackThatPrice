<?php

use App\Http\Controllers\ScraperController;
use App\ProductHandlers\AmazonHandler;
$p = new AmazonHandler("https://www.amazon.ca/Adafruit-Capacitive-Touch-HAT-Raspberry/dp/B00SOXX6SS/ref=sr_1_5");
dump($p->_update());
dump($p);
$url = $p->get_image_url();
echo "<img src=$url>";
// dump(ScraperController::index()->filter("img")->attr("src"));
// echo ScraperController::index();
?>