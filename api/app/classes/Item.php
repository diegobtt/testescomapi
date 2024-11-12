<?php
namespace app\classes;

class Item {

    public $code;
    public $amount;
    public $description;
    public $quantity;
    
    public function __construct($code,$amount,$description,$quantity){
        $this->code = $code;
        $this->amount = $amount;
        $this->description = $description;
        $this->quantity = $quantity;
    }

    
}