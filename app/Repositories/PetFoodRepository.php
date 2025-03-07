<?php

namespace App\Repositories;


use App\Models\PetFood;

class PetFoodRepository extends BaseRepository
{
    public function __construct(PetFood $model)
    {
        parent::__construct($model);
    }

}
