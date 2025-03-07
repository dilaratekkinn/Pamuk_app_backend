<?php

namespace App\Console\Commands;

use App\Http\Services\FireBaseNotificationService;
use App\Models\Pet;
use App\Models\PetFood;
use App\Models\PetRoutine;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Kreait\Firebase\Messaging\CloudMessage;

class pottyCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:potty-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    private $fireBaseNotificationService;

    public function __construct(FireBaseNotificationService $fireBaseNotificationService)
    {
        parent::__construct();
        $this->fireBaseNotificationService = $fireBaseNotificationService;
    }


    public function handle()
    {
        $petIds = Pet::pluck('id');
        foreach ($petIds as $petId) {
            $checkNotify = PetRoutine::where('activity_type' == 'defecation')->where('pet_id', $petId->id)->groupBy('created_at')->count();
            if ($checkNotify > 6) {
                //another cron
                continue;
            }

            $feedingSchedule = PetRoutine::where('activity_type' == 'feeding')->where('pet_id', $petId->id)->latest()->take(2)->get();
            if (count($feedingSchedule) > 1) {
                $lastFeeding = $feedingSchedule->first();
                $previousFeeding = $feedingSchedule->skip(1)->first();

                $lastFeedingTime = Carbon::parse($lastFeeding->activity_time);
                $previousFeedingTime = Carbon::parse($previousFeeding->activity_time);

                $diff = $lastFeedingTime->diffInDays($previousFeedingTime);

                $lastPooping = PetRoutine::where('activity_type' == 'feeding')->where('pet_id', $petId->id)->latest()->first();
                $nextPoopingTime = $lastPooping->activity_time->addHours($diff)->addMinutes(5);
                if ($nextPoopingTime < Carbon::now()) {

                    $this->fireBaseNotificationService->sendNotification($feedingSchedule->pet_id);
                }

            }
        }

    }

}
