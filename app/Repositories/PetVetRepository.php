<?php

namespace App\Repositories;


use App\Models\PetVet;
use Carbon\Carbon;

class PetVetRepository extends BaseRepository
{
    public function __construct(PetVet $model)
    {
        parent::__construct($model);
    }

    public function getVetRoutines($pet_id)
    {
        return PetVet::where('pet_id', $pet_id)->get();

    }

    public function nearest()
    {
        $data = User::selectRaw('(3959 * acos (
     cos ( radians(?) )
     * cos( radians( users.lat ) )
     * cos( radians( users.lon ) - radians(?) )
     + sin ( radians(?) )
     * sin( radians( users.lat )))) AS distance',[$lat, $lon, $lat])
            ->get();
    }

}
