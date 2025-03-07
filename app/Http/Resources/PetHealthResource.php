<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetHealthResource extends JsonResource
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
            'pet_id' => $this->pet_id,
            'health_condition' => $this->health_condition,
            'diagnosis_date' => $this->diagnosis_date,
            'treatment' => $this->treatment,
            'notes' => $this->notes,

        ];

        return $data;
    }
}
