<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetVet extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'pet_veterinary_visits';

    public function getPetVetInfo(){
        return $this -> belongsTo(Pet::class,'pet_id','id');
    }

}
