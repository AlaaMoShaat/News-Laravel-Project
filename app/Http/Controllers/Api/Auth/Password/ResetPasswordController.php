<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Dashboard\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    private $code2;
    public function __construct()
    {
        $this->code2 = new Otp();
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $code = $this->code2->validate($request->email, $request->code);
        if ($code->status == false) {
            return apiResponse(401, 'Code Is Invalid');
        }

        // reset Password
        $user = User::whereEmail($request->email)->first();
        if (!$user) {
            apiResponse(404, 'User Not Found');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return  apiResponse(200, 'Password Updated Successfully');
    }
}
