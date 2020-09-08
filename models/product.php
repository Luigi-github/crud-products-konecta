<?php

class Product {

    public $id;
    public $name;
    public $reference;
    public $price;
    public $weight;
    public $category;
    public $stock;
    public $created_at;
    public $last_selled_at;

    function __construct($dto){
        $this->id = $dto['id'];
        $this->name = $dto['name'];
        $this->reference = $dto['reference'];
        $this->price = $dto['price'];
        $this->weight = $dto['weight'];
        $this->category = $dto['category'];
        $this->stock = $dto['stock'];
        $this->created_at = isset($dto['created_at']) ? $dto['created_at'] : null;
        $this->last_selled_at = isset($dto['last_selled_at']) ? $dto['last_selled_at'] : null;
    }

}

?>