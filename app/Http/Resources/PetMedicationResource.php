<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetMedicationResource extends JsonResource
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
            'medication_name' => $this->medication_name,
            'dosage' => $this->dosage,
            'administration_time' => $this->administration_time,
            'notes' => $this->notes,

        ];

        return $data;
    }
}
