<?php

namespace App\Http\Controllers\API;

use App\Http\ApiResponses\FailResponse;
use App\Http\ApiResponses\SuccessResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PetResource;
use App\Http\Services\PetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PetController extends Controller
{
    private PetService $petService;
    private SuccessResponse $successResponse;
    private FailResponse $failResponse;

    public function __construct(
        PetService      $petService,
        SuccessResponse $successResponse,
        FailResponse    $failResponse,

    )
    {
        $this->failResponse = $failResponse;
        $this->successResponse = $successResponse;
        $this->petService = $petService;
    }

    public function index()
    {
        try {
            return $this->successResponse->setData([
                    'pets' => PetResource::collection($this->petService->index()),
                ]
            )->setMessages(
                Lang::get('Pets are listed Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

    public function show($id)
    {
        try {
            return $this->successResponse->setData([
                'pet' => new PetResource($this->petService->show($id))
            ])->setMessages(
                Lang::get('Pet Showed Successfully'),
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
            $pet = $this->petService->create($request->all());
            return $this->successResponse->setData([
                'pet' => new PetResource($pet)
            ])->setMessages(
                Lang::get('Pet Created Successfully'),
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
            $this->petService->delete($id);
            return $this->successResponse->setMessages(
                Lang::get('Pet Deleted Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }
}
