<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Region;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use function App\Helpers\sluggable_helper_function;

class RoleController extends Controller
{

    public function index(Request $request)
    {

        try {
             if (Gate::denies('roles')) {
                      return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
                  }

            $items = Role::with('permissions')->latest()->paginate(20);

            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت نقش ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    public function getAllRoles()
    {
        try {
            if (Gate::denies('roles')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $items = Role::latest()->get();

            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت نقش با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            if (Gate::denies('view-roles')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $item = Role::with('permissions')->findOrFail($id);
            return response()->json($item);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'نقش یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت نقش با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }



    public function store(Request $request)
    {

        try {
            if (Gate::denies('create-roles')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $data = array_merge($request->all(), ['guard_name' => 'web']);

            $validated = validator($data, [
                'permissions'   => 'nullable|array',
                'permissions.*' => [
                    Rule::exists('permissions', 'id'),
                ],
                'name'        => 'required|unique:roles,name',
                'guard_name' => 'required|string|max:255',
            ])->validate();

            $role = Role::create([
                'name'       => $request->name,
                'guard_name' => $request->guard_name,
            ]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            return response()->json(['message' => 'نقش با موفقیت ایجاد شد.', 'role' => $role], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'ایجاد نقش با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }



    public function update(Request $request, $id)
    {
        try {
            if (Gate::denies('update-roles')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $role = Role::findOrFail($id);

            $data = array_merge($request->all(), ['guard_name' => 'web']);

            $validated = validator($data, [
                'permissions'   => 'nullable|array',
                'permissions.*' => [
                    Rule::exists('permissions', 'id'), // بررسی وجود مجوزها
                ],
                'name'        => [
                    'required',
                    Rule::unique('roles', 'name')->ignore($role->id),
                ],
                'guard_name' => 'required|string|max:255',
            ])->validate();

            $role->update([
                'name'       => $request->name,
                'guard_name' => $request->guard_name,
            ]);

            // به‌روزرسانی مجوزهای مرتبط با نقش
            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions); // استفاده از syncPermissions
            }

            return response()->json(['message' => 'نقش  با موفقیت به‌روزرسانی شد.', 'role' => $role]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'نقش  یافت نشد.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'به‌روزرسانی نقش  با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }



    public function destroy($id)
    {
        try {
            if (Gate::denies('delete-roles')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $item = Role::findOrFail($id);
            $item->delete();

            return response()->json(['message' => 'نقش با موفقیت حذف شد.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'نقش یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حذف نقش با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }



}
