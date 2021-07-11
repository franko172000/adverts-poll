<?php
namespace Franklin\App\Business\Mappers;

class RoomMapper {
    private string $name;
    private string $code;
    private float $netAmount;
    private float $totalAmount;
    private array $taxes = [];

    public function setName(string $name){
        $this->name = $name;
    }

    public function setCode(string $code){
        $this->code = $code;
    }

    public function setNetAmount(float $netAmount){
        $this->netAmount = $netAmount;
    }

    public function setTotalAmount(float $totalAmount){
        $this->totalAmount = $totalAmount;
    }

    public function setTaxes(TaxMapper ...$taxes){
        $this->taxes = $taxes;
    }

    public function getName(){
        return $this->name ?? $this->code.'-'.uniqid();
    }

    public function getCode(){
        return $this->code;
    }
    public function getNetAmount(){
        return $this->netAmount;
    }
    public function getTotalAmount(){
        return $this->totalAmount;
    }

    public function getTaxes(){
        return $this->taxes;
    }
}