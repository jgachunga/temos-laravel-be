<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'desc' => $this->desc,
            'price' => $this->price,
            'discount' => $this->discount,
            'img_url' => $this->img_url,
            'prices' => PriceResource::collection($this->prices)
        ];
    }
}
