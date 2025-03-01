<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
class AdminUserController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('users.index');
        $users = User::latest()->paginate(20);

        return view('back.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('users.create');
        $provinces=Province::Published()->get();
        $roles=Role::all();
        return view('back.users.create',compact('provinces','roles'));
    }


    public function edit(User $user)
    {
        $this->authorize('users.update');
        $provinces=Province::Published()->get();
        $roles=Role::all();
        return view('back.users.edit',compact('user','provinces','roles'));
    }



    public function store(Request $request)
    {
        $this->authorize('users.create');



        $request->validate([
            'fullName' => 'required|string|max:255',
            'mobile' => 'required|digits:11|regex:/^[0][9][0-9]{9,9}$/|unique:users,mobile',
            'jobTitle' => 'required|string|max:255',
            'education' => 'required|string|max:255',
            'nationalCode' => 'required|digits:10|unique:users,nationalCode',
            'email' => 'required|email|unique:users,email',
            'province_id' => 'required|integer|exists:provinces,id',
            'level' => 'required|in:admin,user',
            'password' => 'required|min:6|confirmed',
        ]);


        $user = User::create([
            'id' => Str::uuid()->toString(),
            'fullName' => $request->fullName,
            'jobTitle' => $request->jobTitle,
            'education' => $request->education,
            'nationalCode' => $request->nationalCode,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'level' => $request->level,
            'province_id' => $request->province_id,
            'password' => Hash::make($request->password),
            'mobile_verified_at' => $request->mobile_verified_at ? Carbon::now() : null,
        ]);
        $user->roles()->attach($request->roles);

        toastr()->success('کاربر با موفقیت ایجاد شد');
        return redirect()->route('back.users.index');

    }



    public function update(Request $request, User $user)
    {
        $this->authorize('users.update');

        if($user->level=="creator"){
            abort(403);
        }

        $request->validate([
            'fullName' => 'required|string|max:255',
            'mobile' => 'required|digits:11|regex:/^[0][9][0-9]{9,9}$/|unique:users,mobile,'.$user->id,
            'jobTitle' => 'required|string|max:255',
            'education' => 'required|string|max:255',
            'nationalCode' => 'required|digits:10|unique:users,nationalCode,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'province_id' => 'required|integer|exists:provinces,id',
            'level' => 'required|in:admin,user',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // به‌روزرسانی اطلاعات کاربر
        $user->update([
            'fullName' => $request->fullName,
            'jobTitle' => $request->jobTitle,
            'education' => $request->education,
            'nationalCode' => $request->nationalCode,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'level' => $request->level,
            'province_id' => $request->province_id,
            'mobile_verified_at' => $request->mobile_verified_at=="yes" ? Carbon::now() : null,
        ]);

        // اگر پسورد تغییر کرده باشد
        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // به‌روزرسانی نقش‌های کاربر
        $user->roles()->sync($request->roles);


        toastr()->success('کاربر با موفقیت ویرایش شد');
        return redirect()->route('back.users.index');
    }




    public function destroy(User $user, $multiple = false)
    {
        $this->authorize('users.delete');
        $user->roles()->detach();
        $user->delete();

        if (!$multiple) {
            toastr()->success('کاربر با موفقیت حذف شد');
        }else{
            toastr()->success('کاربران با موفقیت حذف شدند');

        }
        return redirect()->route('back.users.index');
    }

    public function multipleDestroy(Request $request)
    {

        $this->authorize('users.delete');
        $ids=explode(',',$request->ids);
        $newArray = [];

        foreach ($ids as $id) {
            $newArray[] = ['ids' => $id];
        }


        $request->merge(['ids' => $newArray]);
        // $request->validate([
        //     'ids'   => 'required|array',
        //     'ids.*' => [
        //         Rule::exists('users', 'id')->where(function ($query) {
        //             $query->where('id', '!=', Auth::id())->where('level', '!=', 'creator');
        //         })
        //     ]
        // ]);


        foreach ($request->ids as $id) {
            $user = User::find($id['ids']);
            $this->destroy($user, true);
        }
        return redirect()->route('back.users.index');
    }

    public function logout()
    {
        Auth::logout(); // خروج کاربر از سیستم
        return redirect('/'); // هدایت به صفحه اصلی (یا هر مسیری که بخواهید)
    }
}
