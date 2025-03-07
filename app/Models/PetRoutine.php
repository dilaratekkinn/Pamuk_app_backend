<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetRoutine extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getPetInfo(){
        return $this -> belongsTo(Pet::class,'pet_id','id');
    }
}
