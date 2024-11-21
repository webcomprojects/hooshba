<?php

namespace App\Http\Controllers;

use App\Models\verification_code;
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
        $uniqid = uniqid();
        $cach_key = 'mobile_' . $uniqid;

        $code = rand(100000, 999999);

        $request->validate([
            'mobile' => 'required|regex:/^[0][9][0-9]{9,9}$/',
        ]);

        $existingUser = verification_code::where(['mobile' => $request->mobile, 'status' => 1])->first();

        if ($existingUser) {
            return response()->json(['message' => 'این شماره موبایل قبلاً تایید و ثبت شده است.'], 400);
        } else {
            $existingUser = verification_code::where(['mobile' => $request->mobile])->first();
            if ($existingUser) {
                DB::table('verification_codes')
                    ->where('mobile', $request->mobile)
                    ->update([
                        'code' => $code,
                        'expires_at' => now()->addMinutes(6),
                    ]);
            } else {
                DB::table('verification_codes')->insert([
                    'uuid' => Str::uuid()->toString(),
                    'mobile' => $request->mobile,
                    'code' => $code,
                    'expires_at' => now()->addMinutes(6),
                ]);
            }
        }




        Cache::put($cach_key, $request->mobile, now()->addMinutes(6));

        // اینجا می‌توانید کد ارسال پیامک را اضافه کنید
        // مثلا:
        // SmsService::send($request->mobile, "Your verification code is: $code");

        return response()->json(['message' => 'کد تایید با موفقیت ارسال شد.', 'cach_key' => $cach_key, 'code' => $code], 200);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $cachedMobile = Cache::get($request->cach_key);

        if (Cache::has($request->cach_key)) {
            $record = DB::table('verification_codes')
                ->where('mobile', $cachedMobile)
                ->where('code', $request->code)
                ->where('status', 0)
                ->where('expires_at', '>=', now())
                ->first();
            if ($record) {
                DB::table('verification_codes')
                    ->where('uuid', $record->uuid)
                    ->update([
                        'status' => 1,
                    ]);
                return response()->json(['message' => 'شماره موبایل با موفقیت تایید شد.']);
            }
            return response()->json(['message' => 'کد نامعتبر است یا منقضی شده است.'], 422);
        } else {
            return response()->json(['message' => 'زمان شما به پایان رسید.'], 404);
        }


    }

    public function register(Request $request)
    {
        $cachedMobile = Cache::get($request->cach_key);

        $existingUser = User::where('mobile', isset($request->mobile) ? $request->mobile : $cachedMobile)->first();
        if ($existingUser) {
            return response()->json(['message' => 'این شماره موبایل قبلاً تایید و ثبت شده است.'], 400);
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

        Cache::forget($request->cach_key);

        return response()->json([
            'message' => 'کاربر با موفقیت ثبت نام کرد.',
            'token' => $token,
        ], 201);
    }

    public function authentication(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'error' => 'کاربر احراز هویت نشده است.',
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
            return response()->json(['message' => 'اطلاعات ورود نامعتبر است.'], 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'ورود با موفقیت انجام شد.',
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'خروج با موفقیت انجام شد.',
        ]);
    }

    public function resendVerificationCode(Request $request)
    {

        if (Cache::has($request->cach_key)) {
            $cachedMobile = Cache::get($request->cach_key);
            $existingUser = verification_code::where(['mobile' => $cachedMobile, 'status' => 1])->first();

            if ($existingUser) {
                return response()->json(['message' => 'این شماره موبایل قبلاً تایید و ثبت شده است.'], 400);
            } else {
                $code = rand(100000, 999999);

                DB::table('verification_codes')
                    ->where('mobile', $cachedMobile)
                    ->update([
                        'code' => $code,
                        'expires_at' => now()->addMinutes(6),
                    ]);

                Cache::put('mobile', $cachedMobile, now()->addMinutes(6));
            }
        } else {
            return response()->json(['message' => 'زمان شما به پایان رسید.'], 404);
        }



        // اینجا می‌توانید کد ارسال پیامک را اضافه کنید
        // SmsService::send($request->mobile, "Your verification code is: $code");

        return response()->json(['message' => 'کد تایید با موفقیت ارسال شد.', 'code' => $code], 200);
    }

}
