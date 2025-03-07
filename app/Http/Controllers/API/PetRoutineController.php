<?php

namespace App\Http\Controllers\API;

use App\Http\ApiResponses\FailResponse;
use App\Http\ApiResponses\SuccessResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PetRoutineResource;
use App\Http\Services\PetRoutineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PetRoutineController extends Controller
{
    private PetRoutineService $petRoutineService;
    private SuccessResponse $successResponse;
    private FailResponse $failResponse;

    public function __construct(
        PetRoutineService $petRoutineService,
        SuccessResponse   $successResponse,
        FailResponse      $failResponse,

    )
    {
        $this->failResponse = $failResponse;
        $this->successResponse = $successResponse;
        $this->petRoutineService = $petRoutineService;
    }

    public function index()
    {
        try {
            return $this->successResponse->setData([
                    'petRoutines' => PetRoutineResource::collection($this->petRoutineService->index()),
                ]
            )->setMessages(
                Lang::get('Pet Routines are listed Successfully'),
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
            $petRoutine = $this->petRoutineService->create($request->all());
            return $this->successResponse->setData([
                'petRoutine' => new PetRoutineResource($petRoutine)
            ])->setMessages(
                Lang::get('Pet Routine Created Successfully'),
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
            $this->petRoutineService->delete($id);
            return $this->successResponse->setMessages(
                Lang::get('Pet Routine Deleted Successfully'),
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
                'petRoutine' =>  PetRoutineResource::collection($this->petRoutineService->filterByPet((int) $petId))
            ])->setMessages(
                Lang::get('Pet Routine Showed Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }
}
