<?php
namespace Franklin\App\Business\Mappers;
class TaxMapper{
    private string $type;
    private float $amount;
    private string $currency;

    public function setType(string $type){
        $this->type = $type;
    }

    public function setAmount(float $amount){
        $this->amount = $amount;
    }

    public function setCurrency($currency){
        $this->currency = $currency;
    }

    public function getType(){
        return $this->type;
    }

    public function getAmount(){
        return $this->amount;
    }
    public function getCurrency(){
        return$this->currency;
    }
}