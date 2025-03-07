<?php

namespace App\Repositories;

use App\Models\PetRoutine;

class PetRoutineRepository extends BaseRepository
{
    public function __construct(PetRoutine $model)
    {
        parent::__construct($model);
    }

    public function getRoutines($pet_id){
       return PetRoutine::where('pet_id', $pet_id)->get();
    }
}
