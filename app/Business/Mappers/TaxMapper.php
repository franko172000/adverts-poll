<?php
namespace Franklin\App\Business\Mappers;
class TaxMapper{
    /**
     * Tax type
     */
    private string $type;
    /**
     * Tax amount
     */
    private float $amount;
    /**
     * Payment currency
     */
    private string $currency;

    /**
     * Set tax type
     *
     * @param string $type
     * @return void
     */
    public function setType(string $type){
        $this->type = $type;
    }

    /**
     * Set tax amount
     *
     * @param float $amount
     * @return void
     */
    public function setAmount(float $amount){
        $this->amount = $amount;
    }

    /**
     * Set Currency
     *
     * @param string $currency
     * @return void
     */
    public function setCurrency(string $currency){
        $this->currency = $currency;
    }

    /**
     * Get tax type
     *
     * @return string
     */
    public function getType(): string{
        return $this->type;
    }

    /**
     * Get tax amount
     *
     * @return float
     */
    public function getAmount(): float{
        return $this->amount;
    }
    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency(): string{
        return$this->currency;
    }
}