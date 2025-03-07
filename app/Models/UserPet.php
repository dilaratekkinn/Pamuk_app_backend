<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPet extends Model
{
    use HasFactory;

    public function getPetInfo(){
        return $this -> belongsTo(Pet::class,'pet_id','id');
    }
}
