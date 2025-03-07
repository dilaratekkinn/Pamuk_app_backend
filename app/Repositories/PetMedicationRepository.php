<?php

namespace App\Repositories;

use App\Models\PetMedication;

class PetMedicationRepository extends BaseRepository
{
    public function __construct(PetMedication $model)
    {
        parent::__construct($model);
    }

    public function filterByPetId($pet_id){
        return PetMedication::where('pet_id', $pet_id)->get();

    }
}
