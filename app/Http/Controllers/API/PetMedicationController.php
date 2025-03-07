<?php

namespace App\Http\Controllers\API;

use App\Http\ApiResponses\FailResponse;
use App\Http\ApiResponses\SuccessResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PetMedicationResource;
use App\Http\Services\PetMedicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PetMedicationController extends Controller
{
    private PetMedicationService $petMedicationService;
    private SuccessResponse $successResponse;
    private FailResponse $failResponse;

    public function __construct(
        PetMedicationService  $petMedicationService,
        SuccessResponse $successResponse,
        FailResponse    $failResponse,

    )
    {
        $this->failResponse = $failResponse;
        $this->successResponse = $successResponse;
        $this->petMedicationService = $petMedicationService;
    }

    public function index()
    {
        try {
            return $this->successResponse->setData([
                    'petMedication' => PetMedicationResource::collection($this->petMedicationService->index()),
                ]
            )->setMessages(
                Lang::get('Pet Medications are listed Successfully'),
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
            $petMedication = $this->petMedicationService->create($request->all());
            return $this->successResponse->setData([
                'petMedication' => new PetMedicationResource($petMedication)
            ])->setMessages(
                Lang::get('Pet Medication Created Successfully'),
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
            $this->petMedicationService->delete($id);
            return $this->successResponse->setMessages(
                Lang::get('Pet Medication Deleted Successfully'),
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
                'petMedication' => PetMedicationResource::collection($this->petMedicationService->filterByPet($petId)),
            ])->setMessages(
                Lang::get('Pet Medication Showed Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }
}
