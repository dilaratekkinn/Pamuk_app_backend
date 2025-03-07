<?php

namespace App\Repositories;

use App\Models\Reminder;
use Carbon\Carbon;

class ReminderRepository extends BaseRepository
{
    public function __construct(Reminder $model)
    {
        parent::__construct($model);
    }

    public function reminderPet($pet_id){

        return Reminder::where('pet_id',$pet_id)->whereDate('date', '>=', Carbon::today()->toDateString())->get();
    }
}
