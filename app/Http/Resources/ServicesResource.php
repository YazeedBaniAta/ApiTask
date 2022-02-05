<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServicesResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'descriptions'=>$this->descriptions,
            'category'=>$this->category,
        ];
    }
}
