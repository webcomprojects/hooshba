<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'mobile' => 'required|regex:/^[0][9][0-9]{9,9}$/',
        ]);

        $existingUser = User::where('mobile', $request->mobile)->first();
        if ($existingUser) {
            return response()->json(['message' => 'This mobile number is already verified and registered.'], 400);
        }

        $code = rand(100000, 999999);

        DB::table('verification_codes')->insert([
            'uuid' => Str::uuid()->toString(),
            'mobile' => $request->mobile,
            'code' => $code,
            'expires_at' => now()->addMinutes(5),
        ]);

        Cache::put('mobile', $request->mobile, now()->addMinutes(5));

        // اینجا می‌توانید کد ارسال پیامک را اضافه کنید
        // مثلا:
        // SmsService::send($request->mobile, "Your verification code is: $code");

        return response()->json(['message' => 'Verification code sent successfully.'], 200);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $cachedMobile = Cache::get('mobile');
        // if ($cachedCode && $cachedCode == $request->code) {
        //     Cache::forget('verification_code_' . $request->mobile);
        //     return response()->json(['message' => 'Mobile verified successfully.']);
        // }

        $record = DB::table('verification_codes')
            ->where('mobile', $cachedMobile)
            ->where('code', $request->code)
            ->where('expires_at', '>=', now())
            ->first();


        if ($record) {
            DB::table('verification_codes')->where('uuid', $record->uuid)->delete();
            return response()->json(['message' => 'Mobile verified successfully.']);
        }

        return response()->json(['message' => 'Invalid code or code expired.'], 422);
    }

    public function register(Request $request)
    {
        $cachedMobile = Cache::get('mobile');

        $existingUser = User::where('mobile', isset($request->mobile) ? $request->mobile : $cachedMobile)->first();
        if ($existingUser) {
            return response()->json(['message' => 'This mobile number is already verified and registered.'], 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }



        $user = User::create([
            'uuid' => Str::uuid()->toString(),
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $cachedMobile,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        Cache::forget('mobile');

        return response()->json([
            'message' => 'User registered successfully.',
            'token' => $token,
        ], 201);
    }

    public function authentication(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'error' => 'User not authenticated'
            ], 401);
        }

        return response()->json($user, 200);
    }


    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required|regex:/^[0][9][0-9]{9,9}$/',
            'password' => 'required',
        ]);

        $user = User::where('mobile', $request->mobile)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Logged in successfully.',
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}
