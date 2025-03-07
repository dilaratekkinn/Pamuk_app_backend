<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
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
            'name' => $this->name,
            'species' => $this->species,
            'age' => $this->age,
            'pet_image' => asset($this->pet_image != null ? $this->pet_image : 'assets/the_kiddo.jpeg')

        ];

        if ($request->route()->getName() == 'pet.show') {
            $data['vets'] = PetVetResource::collection($this->getPetVets);
            $data['medication'] = PetMedicationResource::collection($this->getPetMedications);
            $data['routines'] = PetRoutineResource::collection($this->getPetRoutines);
            $data['foods'] = PetFoodResource::collection($this->getPetFoods);
            $data['health'] = PetHealthResource::collection($this->getPetHealths);

        }
        return $data;
    }
}
