<?php

namespace App\Http\Controllers\API;

use App\Http\ApiResponses\FailResponse;
use App\Http\ApiResponses\SuccessResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PetVetResource;
use App\Http\Services\PetVetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PetVetController extends Controller
{
    private PetVetService $petVetService;
    private SuccessResponse $successResponse;
    private FailResponse $failResponse;

    public function __construct(
        PetVetService  $petVetService,
        SuccessResponse $successResponse,
        FailResponse    $failResponse,

    )
    {
        $this->failResponse = $failResponse;
        $this->successResponse = $successResponse;
        $this->petVetService = $petVetService;
    }

    public function index()
    {
        try {
            return $this->successResponse->setData([
                    'petVets' => PetVetResource::collection($this->petVetService->index()),
                ]
            )->setMessages(
                Lang::get('Pet Vets are listed Successfully'),
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
            $petVet = $this->petVetService->create($request->all());
            return $this->successResponse->setData([
                'petVet' => new PetVetResource($petVet)
            ])->setMessages(
                Lang::get('Pet Vet Created Successfully'),
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
            $this->petVetService->delete($id);
            return $this->successResponse->setMessages(
                Lang::get('Pet Vet Deleted Successfully'),
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
                'petVet' => PetVetResource::collection($this->petVetService->filterByPet($petId))
            ])->setMessages(
                Lang::get('Pet Vet Showed Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

    public function nearBy(){
        return $this->petVetService->nearBy();
    }
}
