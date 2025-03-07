<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function getPetMedications()
    {
        return $this->hasMany(PetMedication::class);
    }

    public function getPetVets()
    {
        return $this->hasMany(PetVet::class);
    }

    public function getPetRoutines()
    {
        return $this->hasMany(PetRoutine::class);
    }

    public function getPetFoods()
    {
        return $this->hasMany(PetFood::class);

    }

    public function getPetHealths()
    {
        return $this->hasMany(PetHealth::class);

    }
}
