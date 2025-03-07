<?php

namespace App\Http\Controllers\API;

use App\Http\ApiResponses\FailResponse;
use App\Http\ApiResponses\SuccessResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReminderResource;
use App\Http\Services\ReminderService;
use Illuminate\Support\Facades\Lang;

class ReminderController extends Controller
{
    private ReminderService $reminderService;
    private SuccessResponse $successResponse;
    private FailResponse $failResponse;

    public function __construct(
        ReminderService $reminderService,
        SuccessResponse   $successResponse,
        FailResponse      $failResponse,

    )
    {
        $this->failResponse = $failResponse;
        $this->successResponse = $successResponse;
        $this->reminderService = $reminderService;
    }


    public function filterByPetId($petId)
    {
        try {
            return $this->successResponse->setData([
                'reminders' =>  ReminderResource::collection($this->reminderService->filterByPet((int) $petId))
            ])->setMessages(
                Lang::get('Reminders Showed Successfully'),
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
            $this->reminderService->delete($id);
            return $this->successResponse->setMessages(
                Lang::get('Pet Routine Deleted Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }
}
