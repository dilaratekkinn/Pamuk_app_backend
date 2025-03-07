<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ServiceException;
use App\Http\ApiResponses\FailResponse;
use App\Http\ApiResponses\SuccessResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PetFoodResource;
use App\Http\Services\PetFoodService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PetFoodController extends Controller
{
    private PetFoodService $petFoodService;
    private SuccessResponse $successResponse;
    private FailResponse $failResponse;

    public function __construct(
        PetFoodService  $petFoodService,
        SuccessResponse $successResponse,
        FailResponse    $failResponse,

    )
    {
        $this->failResponse = $failResponse;
        $this->successResponse = $successResponse;
        $this->petFoodService = $petFoodService;
    }

    public function index()
    {
        try {
            return $this->successResponse->setData([
                    'petFoods' => PetFoodResource::collection($this->petFoodService->index()),
                ]
            )->setMessages(
                Lang::get('Pet Foods are listed Successfully'),
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
            $petFood = $this->petFoodService->create($request->all());
            return $this->successResponse->setData([
                'petFood' => new PetFoodResource($petFood)
            ])->setMessages(
                Lang::get('Pet Food Created Successfully'),
            )->send();
        } catch (ServiceException $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

    public function delete($id)
    {
        try {
            $this->petFoodService->delete($id);
            return $this->successResponse->setMessages(
                Lang::get('Pet Food Deleted Successfully'),
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
                'petFood' => new PetFoodResource($this->petFoodService->filterByPet($petId))
            ])->setMessages(
                Lang::get('Pet Food Showed Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }
}
