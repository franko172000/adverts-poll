<?php

namespace Franklin\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'room' => $this->name,
            'code' => $this->code,
            'hotel' => $this->hotel->name,
            'hotelStars' => $this->hotel->stars,
            'taxes' => TaxResource::collection($this->taxes),
            'totalTax' => $this->getTotalTax($this->taxes->toArray()),
            'netPrice' => number_format($this->net_amount,2),
            'totalPrice' => number_format($this->total_amount,2)
        ];
    }

    /**
     * Calculate total tax
     *
     * @param array $taxes
     * @return string
     */
    private function getTotalTax(array $taxes): string{
        $total = 0;
        foreach($taxes as $tax){
            $total += $tax['amount'];
        }
        return number_format($total);
    }
}
