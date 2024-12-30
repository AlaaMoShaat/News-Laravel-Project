<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Utils\ImageManeger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpNotify;
use App\Http\Requests\Dashboard\UserRequest;
use App\Jobs\SendOtpTask;
use App\Notifications\SendOtpVerifyUserEmail;
use App\Notifications\SendCodeVerifyUserEmail;

class RegisterController extends Controller
{
    public function register(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->createUser($request);
            if (!$user) {
                return apiResponse(400, 'Try Again Latter!');
            }

            if ($request->hasFile('image')) {
                ImageManeger::uploadImage($request, $user);
            }

            $token = $user->createToken('user_token')->plainTextToken;
            // SendOtpTask::dispatch($user);
            $user->notify(new SendCodeVerifyUserEmail());

            DB::commit();
            return apiResponse(201, 'User Created Successfully ', ['token' => $token]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error From Registration proccess : ' . $e->getMessage());
            return apiResponse(500, 'Enternal server error');
        }
    }

    protected function createUser($request)
    {
        $user = User::create([
            'name' => $request->post('name'),
            'username' => $request->post('username'),
            'email' => $request->post('email'),
            'phone' => $request->post('phone'),
            'country' => $request->post('country'),
            'city' => $request->post('city'),
            'street' => $request->post('street'),
            'password' => $request->post('password'),
        ]);
        return $user;
    }
}
