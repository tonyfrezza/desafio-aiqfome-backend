<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id'    =>  $this->data->id,
            'title' =>  $this->data->title,
            'image' =>  $this->data->image,
            'price' =>  $this->data->price,
            'rating'    =>  $this->data->rating,
        ];
    }
}
