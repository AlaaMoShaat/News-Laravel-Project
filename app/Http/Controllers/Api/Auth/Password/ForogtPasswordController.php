<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpResetPassword;
use App\Notifications\SendCodeResetPassword;

class ForogtPasswordController extends Controller
{
    public function sendCode(Request $request)
    {
        $request->validate(['email' => ['required', 'email', 'exists:users,email', 'max:70']]);
        $user = User::whereEmail($request->email)->first();

        if (!$user) {
            return apiResponse(404, 'User Not Found');
        }

        $user->notify(new SendCodeResetPassword());
        return apiResponse(200, 'Code Send , Check Your Email');
    }
}
