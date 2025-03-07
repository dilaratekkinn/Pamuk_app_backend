<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetFoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'food_type' => $this->food_type,
            'food_brand' => $this->food_brand,
            'amount' => $this->amount,
            'feeding_time' => $this->feeding_time,
            'notes' => $this->notes,

        ];

        return $data;
    }
}
