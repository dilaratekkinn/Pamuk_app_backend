<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetFood extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table="pet_foods";

}
