<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetRoutineResource extends JsonResource
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
            'pet_name' => $this->getPetInfo->name,
            'pet_id' => $this->pet_id,
            'activity_type' => $this->activity_type,
            'activity_time' => $this->activity_time,
            'notes' => $this->notes,

        ];

        return $data;      }
}
