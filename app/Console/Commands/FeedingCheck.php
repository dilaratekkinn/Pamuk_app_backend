<?php

namespace App\Console\Commands;

use App\Http\Services\FireBaseNotificationService;
use App\Models\Pet;
use App\Models\PetAlert;
use App\Models\PetFood;
use App\Models\PetRoutine;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FeedingCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:feeding-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    private $fireBaseNotificationService;

    public function __construct(FireBaseNotificationService $fireBaseNotificationService)
    {
        parent::__construct();
        $this->fireBaseNotificationService = $fireBaseNotificationService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $petIds = Pet::pluck('id');
        foreach ($petIds as $petId) {

            $checkNotify = PetRoutine::where('activity_type' == 'feeding')->where('pet_id', $petId->id)->groupBy('created_at')->count();
            if ($checkNotify > 6) {
                //another cron
                continue;
            }
            $petFoodInfo = PetFood::where('pet_id', $petId)->first();
            $mealPer = [];
            for ($i = 0; $i < $petFoodInfo->meal_repeat; $i++) {
                $checkDailyFoods = PetRoutine::where('pet_id', $petId)
                    ->where('activity_type', 'feeding')
                    ->whereBetween('activity_time', [
                        Carbon::today('UTC')->startOfDay(),
                        Carbon::today('UTC')->endOfDay()
                    ])->get();
                //checkDailyfood yoksa??
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
            if ($lastFeeding) {
                $nextFeedingTime = Carbon::parse($lastFeeding->activity_time)
                    ->addHours($petFoodInfo->time_period)
                    ->addMinutes(5);
                if ($nextFeedingTime <= Carbon::now()) {
                   $this->fireBaseNotificationService->sendNotification($petId);
                    $alert = new PetAlert();
                    $alert->pet_id = $petId;
                    $alert->alert_type = 'feeding';
                    $alert->alert_time=$nextFeedingTime;
                    $alert->status=1;
                    $alert->save();


                }
            }
        }

    }

}
