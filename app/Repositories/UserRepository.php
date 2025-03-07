<?php

namespace App\Repositories;


use App\Mail\ForgotPassword;
use App\Models\User;
use App\Models\UserPet;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function forgotPassword($user)
    {
        $key = Str::random(32);
        $user->remember_token = $key;
        $user->save();
        $url = route('reset.password', ['q' => $user->id * 4, 'k' => $key]);

        Mail::to($user->email)->send(new ForgotPassword($url));

        return true;
    }

    public function getUsersPets($user_id)
    {
        $pet_ids = UserPet::where('user_id', $user_id)->get();
        $info=[];
        foreach ($pet_ids as $pet_id){
            $info[]=$pet_id->getPetInfo;
        }
        return $info;

    }

}
