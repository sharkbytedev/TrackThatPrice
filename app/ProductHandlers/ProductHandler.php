<?php

namespace App\ProductHandlers;

use App\Models\Product as ModelsProduct;

// Class for handling updating products
abstract class ProductHandler
{
    protected const store_name = '';

    protected $url_base = [];

    protected $price;

    protected $name;

    protected $last_updated;

    protected $image_url;

    protected $product_url;

    protected $_obj;

    public function __construct(string $url, ModelsProduct $product = null)
    {
        if (isset($product) && $product->store != $this::store_name) {
            throw new \Exception('Store must be '.$this::store_name);
        }
        $valid = false;
        // Check if the url has a valid base for this store
        foreach ($this->url_base as $u) {
            if (str_starts_with($url, $u)) {
                $valid = true;
                break;
            }
        }
        if (! $valid) {
            throw new \Exception("'$url' has an invalid base");
        }
        $this->product_url = $url;

        if ($product) {
            $this->_obj = $product;
            $this->name = $product->product_name;
            $this->image_url = $product->image_url;
            $this->last_updated = $product->last_queried;
            $this->price = $product->price;
        }
    }

    public function get_price(): float
    {
        return $this->price;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function get_product_url(): string
    {
        return $this->product_url;
    }

    public function get_last_updated(): \DateTime
    {
        return $this->last_updated;
    }

    public function get_image_url(): ?string
    {
        return $this->image_url;
    }

    public function get_as_json(): string
    {
        return json_encode([
            'name' => $this->name,
            'price' => $this->price,
            'last_updated' => $this->last_updated,
            'product_url' => $this->product_url,
            'image_url' => $this->image_url,
        ]);
    }

    // Should return a 2 element array. The first element should be a boolean,
    // and the second should be an exception
    abstract public function update(bool $update_db = false): array;

    abstract public static function from_db_model(ModelsProduct $product): ProductHandler;

    public function create_db_entry(int $update_interval = 3600, bool $save = false): void
    {
        $product = new ModelsProduct([
            'product_name' => $this->name,
            'product_url' => $this->product_url,
            'store' => $this::store_name,
            'update_interval' => $update_interval,
            'price' => $this->price,
        ]);
        $this->_obj = $product;
        if ($save) {
            $product->save();
        }
    }

    protected function _update_db_model(bool $save = false): void
    {
        $this->_obj->product_name = $this->name;
        $this->_obj->product_url = $this->product_url;
        $this->_obj->image_url = $this->image_url;
        $this->_obj->last_queried = $this->last_updated;
        $this->_obj->store = $this::store_name;
        $this->_obj->price = $this->price;
        if ($save) {
            $this->_obj->save();
        }
    }
}
