<?php

namespace App\Repositories;


use App\Models\PetHealth;

class PetHealthRepository extends BaseRepository
{
    public function __construct(PetHealth $model)
    {
        parent::__construct($model);
    }

}
