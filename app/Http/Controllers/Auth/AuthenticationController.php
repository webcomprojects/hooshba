<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\verification_code;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{


    public function sendVerificationCode(Request $request)
    {
        $uniqid = uniqid();
        $cache_key = 'mobile_' . $uniqid;
        $code = rand(100000, 999999);

        $request->validate([
            'mobile' => 'required|digits:11|regex:/^[0][9][0-9]{9,9}$/|unique:users,mobile',
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

        session()->put('verifyCodeSended', $cache_key);
        Cache::put($cache_key, $request->mobile, now()->addMinutes(6));
        //send_sms($request->mobile, $code);

        toastr()->success('کد تایید با موفقیت ارسال شد');

        return redirect()->route('verifyCode');
    }

    public function verifyCode()
    {
        if (session('registerUserInfo')) {
            return redirect()->route('registerUserInfo');
        }
        if (!session('verifyCodeSended')) {
            return redirect('/register');
        }

        return view('auth.verify');
    }

    public function verifyCodeCheck(Request $request)
    {
        if (!session('verifyCodeSended')) {
            return redirect('/register');
        }

        $request->validate([
            'code' => 'required|digits:6',
        ], [
            'code.digits' => 'کد تایید باید 6 رقم باشد'
        ]);



        if (Cache::has(session('verifyCodeSended'))) {
            $cachedMobile = Cache::get(session('verifyCodeSended'));

            $record = DB::table('verification_codes')
                ->where('mobile', $cachedMobile)
                ->where('code', $request->code)
                ->where('expires_at', '>=', now())
                ->first();
            if ($record) {
                DB::table('verification_codes')->where('id', $record->id)->update(['status' => 1]);

                toastr()->success('شماره موبایل با موفقیت تایید شد');

                session()->put('registerUserInfo', session('verifyCodeSended'));

                session()->forget('verifyCodeSended');
                return redirect()->route('registerUserInfo');
            }

            toastr()->error('کد نامعتبر است یا منقضی شده است');

            return redirect('verifyCode')->withInput($request->only('code'));
        } else {

            toastr()->error('زمان شما به پایان رسید');
            session()->forget('verifyCodeSended');
            session()->forget('registerUserInfo');
            return redirect('register');
        }
    }

    public function registerUserInfo()
    {
        if (!session('registerUserInfo')) {
            return redirect('/register');
        }

        $provinces=Province::published()->get();

        return view('auth.userInfo',compact('provinces'));
    }

    public function registerUserInfoStore(Request $request)
    {
        if ($request->level == 'admin') {
            return response()->json(['message' => 'عملیات غیر مجاز است!'], 503);
        }
        if (!session('registerUserInfo')) {
            return redirect('/register');
        }

        if (Cache::has(session('registerUserInfo'))) {

            $cachedMobile = Cache::get(session('registerUserInfo'));

            $existingUser = User::where('mobile', isset($request->mobile) ? $request->mobile : $cachedMobile)->first();
            if ($existingUser) {
                return response()->json(['message' => 'این شماره موبایل قبلاً تایید و ثبت شده است.'], 400);
            }


            $request->validate([
                'fullName' => 'required|string|max:255',
                'jobTitle' => 'required|string|max:255',
                'education' => 'required|string|max:255',
                'nationalCode' => 'required|digits:10|unique:users,nationalCode',
                'email' => 'required|email|unique:users,email',
                'province_id' => 'required|integer|exists:provinces,id',
                'password' => 'required|min:6|confirmed',
            ]);


            $user = User::create([
                'id' => Str::uuid()->toString(),
                'fullName' => $request->fullName,
                'jobTitle' => $request->jobTitle,
                'education' => $request->education,
                'nationalCode' => $request->nationalCode,
                'email' => $request->email,
                'mobile' => $cachedMobile,
                'level' => 'user',
                'province_id' => $request->province_id,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);

            Cache::forget(session('registerUserInfo'));

            toastr()->success(' ثبت با موفقیت انجام شد.');

            return redirect('/');


        } else {
            toastr()->error('زمان شما به پایان رسید');
            session()->forget('registerUserInfo');
            session()->forget('verifyCodeSended');
            return redirect('register');
        }
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
            'mobile' => 'required|digits:11|regex:/^[0][9][0-9]{9,9}$/',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::guard('web')->attempt(['mobile' => $request->mobile, 'password' => $request->password], $request->remember)) {
            // if successful, then redirect to their intended location

            $user = Auth::guard('web')->user();
            User::where('id', $user->id)->update(['updated_at' => Carbon::now()->format('Y-m-d H:m:s')]);
            $request->session()->regenerate();
            $request->session()->put('auth.password_confirmed_at', time());
            toastr()->success('با موفقیت وارد شدید');
            return redirect('/');
        }

        toastr()->error('مشخصات وارد شده با اطلاعات ما سازگار نیست');

        return redirect()->route('login')->withInput($request->only('mobile', 'remember'));
    }

    public function logout(Request $request)
    {
        $request->user()->logout();
        toastr()->success('خروج با موفقیت انجام شد');

        return redirect('/');
    }



    public function resendVerificationCode(Request $request)
    {

        if (Cache::has(session('verifyCodeSended'))) {
            $cachedMobile = Cache::get(session('verifyCodeSended'));

            $code = rand(100000, 999999);

            DB::table('verification_codes')
                ->where('mobile', $cachedMobile)
                ->update([
                    'code' => $code,
                    'expires_at' => now()->addMinutes(6),
                ]);

            Cache::put('mobile', $cachedMobile, now()->addMinutes(6));



        } else {
                 toastr()->error('زمان شما به پایان رسید');
            session()->forget('registerUserInfo');
            session()->forget('verifyCodeSended');
            return redirect('register');
        }


        send_sms($cachedMobile, $code);

        toastr()->success('کد تایید با موفقیت ارسال شد');

        return redirect()->route('verifyCode');

    }


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
