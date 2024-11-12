<?php
namespace app\classes;

class CreditCard {
    
    public $number;
    public $holder_name;
    public $exp_month;
    public $exp_year;
    public $cvv;
    public $billing_adress;
    
    public function __construct($number, $holder_name, $exp_month, $exp_year, $cvv) {
        $this->number = $number;
        $this->holder_name = $holder_name;
        $this->exp_month = $exp_month;
        $this->exp_year = $exp_year;
        $this->cvv = $cvv;
        $this->billing_adress = [
                                "line_1" => "10880, Malibu Point, Malibu Central",
                                "zip_code" => "90265",
                                "city" => "Malibu",
                                "state" => "CA",
                                "country" => "US"
        ];
    }
}