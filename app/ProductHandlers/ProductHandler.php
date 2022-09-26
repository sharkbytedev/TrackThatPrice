<?php

namespace App\ProductHandlers;

// Class for handling updating products
abstract class ProductHandler {
    protected $price;
    protected $name;
    protected $last_updated;
    protected $image_url;
    protected $product_url;
    protected $_obj;
    
    public function get_price(): float {
        return $this->price;
    }
    public function get_name(): string {
        return $this->name;
    }
    public function get_product_url(): string {
        return $this->product_url;
    }
    public function get_last_updated(): \DateTime {
        return $this->last_updated;
    }
    public function get_image_url(): ?string {
        return $this->image_url;
    }
    public function get_as_json(): string {
        return json_encode([
            "name"=>$this->name,
            "price"=>$this->price,
            "last_updated"=>$this->last_updated,
            "product_url"=>$this->product_url,
            "image_url"=>$this->image_url
        ]);
    }
    // Should return a 2 element array. The first element should be a boolean, 
    // and the second should be an exception
    abstract public function _update(): Array;
}