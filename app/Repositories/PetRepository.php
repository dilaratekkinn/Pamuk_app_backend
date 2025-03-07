<?php

namespace App\Repositories;

use App\Models\Pet;

class PetRepository extends BaseRepository
{
    public function __construct(Pet $model)
    {
        parent::__construct($model);
    }


}
