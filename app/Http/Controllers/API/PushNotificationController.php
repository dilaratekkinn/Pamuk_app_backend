<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\PetFood;
use App\Models\PetRoutine;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    public function index(Request $request)
    {

        $petIds = Pet::pluck('id');
        foreach ($petIds as $petId) {
            $petFoodInfo = PetFood::where('pet_id', $petId)->first();
            $mealPer = [];
            for ($i = 0; $i < $petFoodInfo->meal_repeat; $i++) {
                $checkDailyFoods = PetRoutine::where('pet_id', $petId)
                    ->where('activity_type', 'feeding')
                    ->whereBetween('activity_time', [
                        Carbon::today('UTC')->startOfDay(),
                        Carbon::today('UTC')->endOfDay()
                    ])->get();
                foreach ($checkDailyFoods as $checkDailyFood) {
                    if (Carbon::parse($checkDailyFood->activity_time) < Carbon::now()) {
                        $mealPer[] = $checkDailyFood;
                    }
                }
                if (count($mealPer) == $petFoodInfo->meal_repeat) {
                    print_r('tamam');
                    break;
                }
            }
            $lastFeeding = PetRoutine::where('activity_type', 'feeding')->where('pet_id', $petId)->latest()->first();
            dd($lastFeeding);
            if ($lastFeeding) {
                $nextFeedingTime = Carbon::parse($lastFeeding->activity_time)
                    ->addHours($petFoodInfo->time_period)
                    ->addMinutes(5);
                if ($nextFeedingTime <= Carbon::now()) {
                    $this->fireBaseNotificationService->sendNotification($petId);
                }
            }
        }

    }


}
