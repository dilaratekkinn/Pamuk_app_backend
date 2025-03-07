<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetVetResource extends JsonResource
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
            'pet_name' => $this->getPetVetInfo->name,
            'visit_date' => $this->visit_date,
            'vet_name' => $this->vet_name,
            'reason' => $this->reason,
            'notes' => $this->notes,

        ];

        return $data;
    }
}
