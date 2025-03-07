<?php

namespace App\Repositories;


use App\Models\VetCareCenter;
use Carbon\Carbon;

class VetCareCenterRepository extends BaseRepository
{
    public function __construct(VetCareCenter $model)
    {
        parent::__construct($model);
    }


    public function nearest($latitude, $longitude)
    {
        return  VetCareCenter::selectRaw('vet_care_centers.*,
        (3959 * acos (
     cos ( radians(?) )
     * cos( radians( vet_care_centers.latitude ) )
     * cos( radians( vet_care_centers.longitude ) - radians(?) )
     + sin ( radians(?) )
     * sin( radians( vet_care_centers.latitude ))
)) AS distance', [$latitude, $longitude, $latitude])
            ->orderBy('distance', 'asc')
            ->take(5)
            ->get();


     }


}
