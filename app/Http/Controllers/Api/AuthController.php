<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\verification_code;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use function App\Helpers\insert_user_meta;
use function App\Helpers\send_sms;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="API Documentation",
 *         version="1.0.0",
 *         description="This is the API documentation for the project."
 *     ),
 *     @OA\Server(
 *         url="https://hooshba.webcomcoai.com/api",
 *         description="Local Development Server"
 *     )
 * )
 */
class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/send-verification-code",
     *     summary="Send a verification code",
     *     description="این متد برای ارسال کد تایید به شماره موبایل استفاده می‌شود.",
     *     operationId="sendVerificationCode",
     *     tags={"Authentication"},
     *     @OA\Parameter(
     *         name="mobile",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="09121234567"
     *         ),
     *         description="شماره موبایل کاربر"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="کد تایید با موفقیت ارسال شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="کد تایید با موفقیت ارسال شد."),
     *             @OA\Property(property="cache_key", type="string", example="mobile_12345"),
     *             @OA\Property(property="code", type="integer", example=123456)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="این شماره موبایل قبلاً تایید و ثبت شده است.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="این شماره موبایل قبلاً تایید و ثبت شده است.")
     *         )
     *     )
     * )
     */
    public function sendVerificationCode(Request $request)
    {
        $uniqid = uniqid();
        $cache_key = 'mobile_' . $uniqid;

        $code = rand(100000, 999999);

        $request->validate([
            'mobile' => 'required|digits:11|regex:/^[0][9][0-9]{9,9}$/',
        ]);


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
                'id' => Str::uuid()->toString(),
                'mobile' => $request->mobile,
                'code' => $code,
                'expires_at' => now()->addMinutes(6),
            ]);
        }

        Cache::put($cache_key, $request->mobile, now()->addMinutes(6));

        send_sms($request->mobile, $code);

        return response()->json(['message' => 'کد تایید با موفقیت ارسال شد.', 'cache_key' => $cache_key], 200);
    }
    /*    public function sendVerificationCode(Request $request)
        {
            $uniqid = uniqid();
            $cache_key = 'mobile_' . $uniqid;

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
                        'id' => Str::uuid()->toString(),
                        'mobile' => $request->mobile,
                        'code' => $code,
                        'expires_at' => now()->addMinutes(6),
                    ]);
                }
            }




            Cache::put($cache_key, $request->mobile, now()->addMinutes(6));

            // اینجا می‌توانید کد ارسال پیامک را اضافه کنید
            // مثلا:
            // SmsService::send($request->mobile, "Your verification code is: $code");

            return response()->json(['message' => 'کد تایید با موفقیت ارسال شد.', 'cache_key' => $cache_key, 'code' => $code], 200);
        }*/

    /**
     * @OA\Post(
     *     path="/verify-code",
     *     summary="Verify the verification code",
     *     description="این متد برای تایید کد ارسالی استفاده می‌شود.",
     *     operationId="verifyCode",
     *     tags={"Authentication"},
     *     @OA\Parameter(
     *         name="cache_key",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="mobile_12345"
     *         ),
     *         description="کلید ذخیره شده برای موبایل"
     *     ),
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=123456
     *         ),
     *         description="کد تایید ارسال شده"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="شماره موبایل با موفقیت تایید شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="شماره موبایل با موفقیت تایید شد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="کد نامعتبر است یا منقضی شده است.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="کد نامعتبر است یا منقضی شده است.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="زمان شما به پایان رسید.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="زمان شما به پایان رسید.")
     *         )
     *     )
     * )
     */


    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);


        if (Cache::has($request->cache_key)) {

            $cachedMobile = Cache::get($request->cache_key);

            $record = DB::table('verification_codes')
                ->where('mobile', $cachedMobile)
                ->where('code', $request->code)
                ->where('expires_at', '>=', now())
                ->first();
            if ($record) {
                DB::table('verification_codes')->where('id', $record->id)->update(['status' => 1]);
                if (User::where('mobile', $cachedMobile)->exists()) {
                    $registered = true;
                } else {
                    $registered = false;
                }
                return response()->json([
                    'registered' => $registered,
                    'message' => 'شماره موبایل با موفقیت تایید شد.'
                ]);
            }
            return response()->json(['message' => 'کد نامعتبر است یا منقضی شده است.'], 422);
        } else {
            return response()->json(['message' => 'زمان شما به پایان رسید.'], 400);
        }



    }

    /*    public function verifyCode(Request $request)
        {
            $request->validate([
                'code' => 'required|digits:6',
            ]);

            $cachedMobile = Cache::get($request->cache_key);

            if (Cache::has($request->cache_key)) {
                $record = DB::table('verification_codes')
                    ->where('mobile', $cachedMobile)
                    ->where('code', $request->code)
                    ->where('status', 0)
                    ->where('expires_at', '>=', now())
                    ->first();
                if ($record) {
                    DB::table('verification_codes')
                        ->where('id', $record->id)
                        ->update([
                            'status' => 1,
                        ]);
                    return response()->json(['message' => 'شماره موبایل با موفقیت تایید شد.']);
                }
                return response()->json(['message' => 'کد نامعتبر است یا منقضی شده است.'], 422);
            } else {
                return response()->json(['message' => 'زمان شما به پایان رسید.'], 404);
            }
        }*/

    /**
     * @OA\Post(
     *     path="/register",
     *     summary="Register a new user",
     *     description="این متد برای ثبت کاربر جدید استفاده می‌شود.",
     *     operationId="register",
     *     tags={"Authentication"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="John Doe"
     *         ),
     *         description="نام کامل کاربر"
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="john.doe@example.com"
     *         ),
     *         description="ایمیل کاربر"
     *     ),
     *     @OA\Parameter(
     *         name="province_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="number",
     *             example="21"
     *         ),
     *         description="شهر کاربر"
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="password123"
     *         ),
     *         description="رمز عبور کاربر"
     *     ),
     *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="password123"
     *         ),
     *         description="تایید رمز عبور"
     *     ),
     *     @OA\Parameter(
     *         name="cache_key",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="mobile_12345"
     *         ),
     *         description="کلید ذخیره شده برای موبایل"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="کاربر با موفقیت ثبت نام کرد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="کاربر با موفقیت ثبت نام کرد."),
     *             @OA\Property(property="token", type="string", example="token12345")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="این شماره موبایل قبلاً تایید و ثبت شده است.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="این شماره موبایل قبلاً تایید و ثبت شده است.")
     *         )
     *     )
     * )
     */


    public function register(Request $request)
    {
        if ($request->level == 'admin') {
            return response()->json(['message' => 'عملیات غیر مجاز است!'], 503);
        }

        if (Cache::has($request->cache_key)) {

            $cachedMobile = Cache::get($request->cache_key);

            $existingUser = User::where('mobile', isset($request->mobile) ? $request->mobile : $cachedMobile)->first();
            if ($existingUser) {
                return response()->json(['message' => 'این شماره موبایل قبلاً تایید و ثبت شده است.'], 400);
            }



            $validator = Validator::make($request->all(), [
                'fullName' => 'required|string|max:255',
                'jobTitle' => 'required|string|max:255',
                'education' => 'required|string|max:255',
                'nationalCode' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'province_id' => 'required|integer|exists:provinces,id',
                'password' => 'required|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user = User::create([
                'id' => Str::uuid()->toString(),
                'fullName' => $request->name,
                'jobTitle' => $request->jobTitle,
                'education' => $request->education,
                'nationalCode' => $request->nationalCode,
                'email' => $request->email,
                'mobile' => $cachedMobile,
                'level' => $request->level,
                'province_id' => $request->province_id,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            Cache::forget($request->cache_key);

            return response()->json([
                'message' => 'کاربر با موفقیت ثبت نام کرد.',
                'token' => $token,
            ], 201);
        } else {
            return response()->json(['message' => 'زمان شما به پایان رسید.'], 400);
        }
    }

    /*    public function register(Request $request)
        {
            $cachedMobile = Cache::get($request->cache_key);

            $existingUser = User::where('mobile', isset($request->mobile) ? $request->mobile : $cachedMobile)->first();
            if ($existingUser) {
                return response()->json(['message' => 'این شماره موبایل قبلاً تایید و ثبت شده است.'], 400);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'province_id' => 'required|number|exists:provinces,id'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user = User::create([
                'id' => Str::uuid()->toString(),
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $cachedMobile,
                'province_id' => $request->province_id,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            Cache::forget($request->cache_key);

            return response()->json([
                'message' => 'کاربر با موفقیت ثبت نام کرد.',
                'token' => $token,
            ], 201);
        }*/

    /**
     * @OA\Post(
     *     path="/authentication",
     *     summary="Authenticate the user",
     *     description="این متد بررسی می‌کند که آیا کاربر احراز هویت شده است یا خیر.",
     *     operationId="authentication",
     *     tags={"Authentication"},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *         ),
     *         description="توکن احراز هویت به صورت Bearer Token"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="کاربر احراز هویت شده است.",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="mobile", type="string", example="09121234567")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="کاربر احراز هویت نشده است.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="کاربر احراز هویت نشده است.")
     *         )
     *     )
     * )
     */


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

    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Log in a user",
     *     description="این متد برای ورود کاربر استفاده می‌شود.",
     *     operationId="login",
     *     tags={"Authentication"},
     *     @OA\Parameter(
     *         name="mobile",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="09121234567"
     *         ),
     *         description="شماره موبایل کاربر"
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="password123"
     *         ),
     *         description="رمز عبور کاربر"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="ورود با موفقیت انجام شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="ورود با موفقیت انجام شد."),
     *             @OA\Property(property="token", type="string", example="token12345")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="اطلاعات ورود نامعتبر است.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="اطلاعات ورود نامعتبر است.")
     *         )
     *     )
     * )
     */

    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:11|regex:/^[0][9][0-9]{9,9}$/',
            'password' => 'required',
        ]);

        $user = User::where('mobile', $request->mobile)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'اطلاعات ورود نامعتبر است.'], 404);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'ورود با موفقیت انجام شد.',
            'token' => $token,
        ]);
    }

    /*  public function login(Request $request)
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
      }*/

    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Log out a user",
     *     description="این متد برای خروج کاربر استفاده می‌شود و تمام توکن‌های کاربر را باطل می‌کند.",
     *     operationId="logout",
     *     tags={"Authentication"},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *         ),
     *         description="توکن احراز هویت به صورت Bearer Token"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="خروج با موفقیت انجام شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="خروج با موفقیت انجام شد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="کاربر احراز هویت نشده است.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="کاربر احراز هویت نشده است.")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'خروج با موفقیت انجام شد.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/resend-verification-code",
     *     summary="Resend the verification code",
     *     description="این متد برای ارسال مجدد کد تایید به شماره موبایل استفاده می‌شود.",
     *     operationId="resendVerificationCode",
     *     tags={"Authentication"},
     *     @OA\Parameter(
     *         name="cache_key",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="mobile_12345"
     *         ),
     *         description="کلید ذخیره شده برای موبایل"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="کد تایید با موفقیت ارسال شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="کد تایید با موفقیت ارسال شد."),
     *             @OA\Property(property="code", type="integer", example=123456)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="این شماره موبایل قبلاً تایید و ثبت شده است.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="این شماره موبایل قبلاً تایید و ثبت شده است.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="زمان شما به پایان رسید.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="زمان شما به پایان رسید.")
     *         )
     *     )
     * )
     */

    public function resendVerificationCode(Request $request)
    {

        if (Cache::has($request->cache_key)) {
            $cachedMobile = Cache::get($request->cache_key);

            $code = rand(100000, 999999);

            DB::table('verification_codes')
                ->where('mobile', $cachedMobile)
                ->update([
                    'code' => $code,
                    'expires_at' => now()->addMinutes(6),
                ]);

            Cache::put('mobile', $cachedMobile, now()->addMinutes(6));
        } else {
            return response()->json(['message' => 'زمان شما به پایان رسید.'], 400);
        }


        send_sms($cachedMobile, $code);

        return response()->json(['message' => 'کد تایید با موفقیت ارسال شد.'], 200);
    }
    /*    public function resendVerificationCode(Request $request)
        {

            if (Cache::has($request->cache_key)) {
                $cachedMobile = Cache::get($request->cache_key);
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
        }*/

    public function register_expert(Request $request)
    {
        if ($request->level == 'admin') {
            return response()->json(['message' => 'عملیات غیر مجاز است!'], 503);
        }

        if (Cache::has($request->cache_key)) {

            $cachedMobile = Cache::get($request->cache_key);

            $existingUser = User::where('mobile', isset($request->mobile) ? $request->mobile : $cachedMobile)->first();
            if ($existingUser) {
                return response()->json(['message' => 'این شماره موبایل قبلاً تایید و ثبت شده است.'], 400);
            }

            // $validator = Validator::make($request->all(), [
            //     'name' => 'required|string|max:255',
            //     'email' => 'required|email|unique:users,email',
            //     'province_id' => 'required|integer|exists:provinces,id',
            //     'password' => 'required|min:8|confirmed',
            // ]);

            // if ($validator->fails()) {
            //     return response()->json(['errors' => $validator->errors()], 422);
            // }

            $user = User::create([
                'id' => Str::uuid()->toString(),
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $cachedMobile,
                'level' => $request->level,
                'province_id' => $request->province_id,
                'password' => Hash::make($request->password),
            ]);

            insert_user_meta($user->id, 'register_info', $request->info);

            $token = $user->createToken('auth_token')->plainTextToken;

            Cache::forget($request->cache_key);

            return response()->json([
                'message' => 'کاربر با موفقیت ثبت نام کرد.',
                'token' => $token,
            ], 201);
        } else {
            return response()->json(['message' => 'زمان شما به پایان رسید.'], 400);
        }
    }

    public function experts_list(Request $request)
    {
        $user = $request->user();
        if ($user->level == 'council' or $user->level == 'admin') {
            $users = User::with('usermetas')->where('level', 'expert')->get();
            return $users;
        } else {
            return response()->json(['message' => 'دسترسی مجاز نیست.'], 503);
        }
    }
}
