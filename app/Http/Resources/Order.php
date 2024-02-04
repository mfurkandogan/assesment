<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'id' => $this->id,
            'customer_id' => $this->whenLoaded('customer', function () {
                return $this->customer->id;
            }),
            'items' => $this->whenLoaded('orderItems', function () {
                return OrderItem::collection($this->orderItems);
            }),
            'total' => $this->total
        ];
    }
}
