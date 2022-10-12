<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Jobs\UpdateProductData;
use Illuminate\Support\Facades\Log;

class UpdateProducts extends Command
{
    protected $signature = 'products:update {interval}';

    protected $description = 'Update product data';

    public function handle()
    {
        $this->info("Updating products with interval ".strval($this->argument("interval")));
        $this->withProgressBar(Product::where("update_interval", $this->argument("interval"))->where("valid", true)->get(), function($product) {
            UpdateProductData::dispatch($product);
        });
    }
}
