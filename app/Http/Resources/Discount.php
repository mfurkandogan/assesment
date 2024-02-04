<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Discount extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'orderId' => $this["orderId"],
            'discounts' => $this["discounts"],
            'totalDiscount' => $this["totalDiscount"],
            'discountedTotal' => $this["discountedTotal"]
        ];
    }
}
