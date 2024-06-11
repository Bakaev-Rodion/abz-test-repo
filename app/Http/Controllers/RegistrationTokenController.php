<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\RegistrationToken;

class RegistrationTokenController extends Controller
{

    public function getRegistrationToken(){
        $token = $this->generateToken();
        $this->saveRegistrationToken($token, $this->getExpiresAtTime());

        return response()->json(['success'=>true, 'token'=>$token]);
    }
    private function saveRegistrationToken($token, $expiresAt){
        RegistrationToken::create(
            ['token'=>$token, 'expires_at'=>$expiresAt]
        );
    }
    private function generateToken(){
        return Str::random(102);
    }
    private function getExpiresAtTime(){
        return Carbon::now()->addMinutes(40);
    }
}
