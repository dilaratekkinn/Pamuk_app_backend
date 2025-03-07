<?php

namespace App\Http\Controllers\API;

use App\Http\ApiResponses\FailResponse;
use App\Http\ApiResponses\SuccessResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PetHealthResource;
use App\Http\Services\PetHealthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PetHealthController extends Controller
{
    private PetHealthService $petHealthService;
    private SuccessResponse $successResponse;
    private FailResponse $failResponse;

    public function __construct(
        PetHealthService $petHealthService,
        SuccessResponse  $successResponse,
        FailResponse     $failResponse,

    )
    {
        $this->failResponse = $failResponse;
        $this->successResponse = $successResponse;
        $this->petHealthService = $petHealthService;
    }

    public function index()
    {
        try {
            return $this->successResponse->setData([
                    'petHealths' => PetHealthResource::collection($this->petHealthService->index()),
                ]
            )->setMessages(
                Lang::get('Pet Healths are listed Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

    public function create(Request $request)
    {
        try {
            $petHealth = $this->petHealthService->create($request->all());
            return $this->successResponse->setData([
                'petHealth' => new PetHealthResource($petHealth)
            ])->setMessages(
                Lang::get('Pet Health Created Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }


    public function delete($id)
    {
        try {
            $this->petHealthService->delete($id);
            return $this->successResponse->setMessages(
                Lang::get('Pet Health Deleted Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

    public function filterByPetId($petId)
    {
        try {
            return $this->successResponse->setData([
                'petHealth' => new PetHealthResource($this->petHealthService->filterByPet($petId))
            ])->setMessages(
                Lang::get('Pet Health Showed Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }
}
