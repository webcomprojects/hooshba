<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function index(Request $request)
    {

        try {
            if (Gate::denies('users')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $items = User::latest()->paginate(20);

            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت کاربران با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }



    public function show($id)
    {
        try {
            if (Gate::denies('view-users')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $item = User::findOrFail($id);
            return response()->json($item);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'کاربر یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت کاربر با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }



    public function store(Request $request)
    {

        try {
            if (Gate::denies('create-users')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'mobile' => 'required|digits:11|regex:/^[0][9][0-9]{9,9}$/|unique:users,mobile',
                'province_id' => 'required|integer|exists:provinces,id',
                'level' => 'required|in:user,admin',
                'roles'      => 'nullable|array',
                'password' => 'required|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }



            $user = User::create([
                'id' => Str::uuid()->toString(),
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'level' => $request->level,
                'province_id' => $request->province_id,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole($request->roles);


            return response()->json(['message' => 'کاربر با موفقیت ایجاد شد.', 'user' => $user], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'ایجاد کاربر با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }



    public function update(Request $request, $id)
    {
        try {
            if (Gate::denies('update-users')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'mobile' => 'required|digits:11|regex:/^[0][9][0-9]{9,9}$/|unique:users,mobile,' . $id,
                'level' => 'required|in:user,admin',
                'province_id' => 'required|integer|exists:provinces,id',
                'roles'      => 'nullable|array',
                'password' => 'nullable|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }


            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'level' => $request->level,
                'province_id' => $request->province_id,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);

            if ($request->has('roles')) {
                $user->syncRoles($request->roles);
            }

            return response()->json(['message' => 'کاربر با موفقیت به‌روزرسانی شد.', 'user' => $user]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'کاربر یافت نشد.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'به‌روزرسانی کاربر با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }



    public function destroy($id)
    {
        try {
            if (Gate::denies('delete-users')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $item = User::findOrFail($id);
            $item->roles()->detach();

            $item->delete();

            return response()->json(['message' => 'کاربر با موفقیت حذف شد.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'کاربر یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حذف کاربر با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


}
