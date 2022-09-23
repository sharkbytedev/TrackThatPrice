<?php

// Class for handling updating products
abstract class ProductHandler {
    protected $price;
    protected $name;
    protected $last_updated;
    protected $image_url;
    protected $product_url;
    protected $_obj;
    
    abstract public function get_price(): float;
    abstract public function get_name(): string;
    abstract public function get_product_url(): string;
    abstract public function get_last_updated(): DateTime;
    abstract public function get_image_url(): ?string;
    public function get_as_json(): string {
        return json_encode([
            "name"=>$this->name,
            "price"=>$this->price,
            "last_updated"=>$this->last_updated,
            "product_url"=>$this->product_url,
            "image_url"=>$this->image_url
        ]);
    }
    abstract public function _update(): bool;
}