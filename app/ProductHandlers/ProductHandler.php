<?php

namespace App\ProductHandlers;


// Interface for handling updating products
interface ProductHandler
{
    public function crawl(): ProductDetails;
}
