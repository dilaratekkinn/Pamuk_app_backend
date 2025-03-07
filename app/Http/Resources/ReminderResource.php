<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReminderResource extends JsonResource
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
            'pet_name' => $this->getReminderByPet->name,
            'date' => $this->date,
            'time' => $this->time,
            'reason' => $this->reason,
        ];

        return $data;
    }
}
