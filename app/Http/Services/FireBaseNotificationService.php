<?php

namespace App\Http\Services;

use App\Models\UserFireBaseToken;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Messaging\CloudMessage;


class FireBaseNotificationService
{

    public function sendNotification($petId)
    {
        $messaging = app('firebase.messaging');
        $userInfos = UserFireBaseToken::where('user_id', auth()->user()->id)->get();
        $userTokens = [];
        foreach ($userInfos as $userInfo) {
            $userTokens[] = $userInfo['token'];
        }

        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => $petId,
                'body' => 'Kakaya çıkarttın mı?',
            ]
        ]);
        $messaging->sendMulticast($message, $userTokens);
    }

}
