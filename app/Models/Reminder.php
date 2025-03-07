<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    public function getReminderByPet()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'id');
    }
}
