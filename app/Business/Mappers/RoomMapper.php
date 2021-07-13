<?php
namespace Franklin\App\Business\Mappers;

class RoomMapper {
    /**
     * Room name
     */
    private string $name;
    /**
     * Room code
     */
    private string $code;
    /**
     * Net amount
     */
    private float $netAmount;
    /**
     * Total Amount
     */
    private float $totalAmount;
    /**
     * Taxes
     */
    private array $taxes = [];

    /**
     * Set room name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name){
        $this->name = $name;
    }

    /**
     * Set room code
     *
     * @param string $code
     * @return void
     */
    public function setCode(string $code){
        $this->code = $code;
    }

    /**
     * Set net amount
     *
     * @param float $netAmount
     * @return void
     */
    public function setNetAmount(float $netAmount){
        $this->netAmount = $netAmount;
    }

    /**
     * Set total amount
     *
     * @param float $totalAmount
     * @return void
     */
    public function setTotalAmount(float $totalAmount){
        $this->totalAmount = $totalAmount;
    }

    /**
     * Set tax array
     *
     * @param TaxMapper ...$taxes
     * @return void
     */
    public function setTaxes(TaxMapper ...$taxes){
        $this->taxes = $taxes;
    }

    /**
     * Get room name
     *
     * @return void
     */
    public function getName(): string{
        return $this->name ?? $this->code.'-'.uniqid();
    }

    /**
     * Get code
     *
     * @return void
     */
    public function getCode(): string{
        return $this->code;
    }

    /**
     * Get net amount
     *
     * @return float
     */
    public function getNetAmount(): float{
        return $this->netAmount;
    }

    /**
     * Get total amount
     *
     * @return float
     */
    public function getTotalAmount(): float{
        return $this->totalAmount;
    }

    /**
     * Get taxes
     *
     * @return array
     */
    public function getTaxes(): array{
        return $this->taxes;
    }
}