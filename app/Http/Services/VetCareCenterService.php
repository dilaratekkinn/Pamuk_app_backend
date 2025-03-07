<?php

namespace App\Http\Services;


use App\Repositories\VetCareCenterRepository;

class VetCareCenterService
{

    private VetCareCenterRepository $vetCareCenterRepository;

    public function __construct(
        VetCareCenterRepository $vetCareCenterRepository,
    )
    {
        $this->vetCareCenterRepository = $vetCareCenterRepository;
    }

    public function findCareCenterNearByUser(array $parameters)
    {
        $latitude = $parameters['latitude'];
        $longitude = $parameters['longitude'];

        return $this->vetCareCenterRepository->nearest($latitude, $longitude);
    }

}
