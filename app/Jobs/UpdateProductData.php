<?php

namespace App\Jobs;

use App\Exceptions\QueryExceptions;
use App\Models\HistoricalData;
use App\Models\Product;
use App\ProductHandlers\ProductHandlerFactory;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class UpdateProductData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function handle()
    {
        Log::withContext(['product_id' => $this->product->id]);
        $old_price = $this->product->price;
        try {
            $details = ProductHandlerFactory::new($this->product)->crawl($this->product);
            $this->product->product_name = $details->name;
            $this->product->price = $details->price;
            $this->product->image_url = $details->image_url;
            $this->product->store_id = $details->store_id;
            $this->product->upc = $details->upc;
            $this->product->save();
        }
        // TODO: Some way to notify users after a product they are tracking errors

        // Server errors are likely temporary, so simply ignore it and log the error
        catch (QueryExceptions\ServerError $e) {
            Log::notice('Recieved a 500 response while updating a product');

            return;
        }
        // Gone means the resource will never return, so mark the product as invalid.
        // Not found will usually mean the same thing, so we'll treat it the same
        catch (QueryExceptions\GoneError | QueryExceptions\NotFoundError $e) {
            $this->product->valid = false;
            $this->product->save();
            Log::notice('Product resource not found/gone');

            return;
        }
        // A bad request could be either the user's fault or the handler's fault, so disable and log the error
        catch (QueryExceptions\BadRequestError $e) {
            $this->product->valid = false;
            $this->product->save();
            Log::alert('Recieved a 400 while updating a product');

            return;
        } catch (InvalidArgumentException $e) {
            // For now just log the error and disable. In the future, this will notify users/maintainers
            $this->product->valid = false;
            $this->product->save();
            Log::error('Error while parsing data from product', ['exception' => $e]);

            return;
        } catch (Exception $e) {
            Log::error('Unhandled error while updating product data', ['exception' => $e]);

            return;
        }

        if (isset($old_price)) {
            $hd = new HistoricalData(['price' => $old_price, 'product_id' => $this->product->id]);
            $hd->save();
        }
    }
}
