<?php

namespace Franklin\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxResource extends JsonResource
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
            'currency' => $this->currency,
            'taxtType' => $this->type ?? 'NIL',
            'amount' => number_format($this->amount,2),
        ];
    }
}
