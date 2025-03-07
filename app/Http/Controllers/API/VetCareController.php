<?php

namespace App\Http\Controllers\API;

use App\Http\ApiResponses\FailResponse;
use App\Http\ApiResponses\SuccessResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PetVetResource;
use App\Http\Services\PetVetService;
use App\Http\Services\VetCareCenterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class VetCareController extends Controller
{
    private VetCareCenterService $vetCareCenterService;
    private SuccessResponse $successResponse;
    private FailResponse $failResponse;

    public function __construct(
        VetCareCenterService  $vetCareCenterService,
        SuccessResponse $successResponse,
        FailResponse    $failResponse,

    )
    {
        $this->failResponse = $failResponse;
        $this->successResponse = $successResponse;
        $this->vetCareCenterService = $vetCareCenterService;
    }


    public function findCareCenterNearByUser(Request $request){

        return $this->vetCareCenterService->findCareCenterNearByUser($request->all());

    }
}
