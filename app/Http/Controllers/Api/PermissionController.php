<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    public function index(Request $request)
    {

        try {
            if (Gate::denies('permissions')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $items = Permission::latest()->paginate(20);

            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت مجوز ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    public function getAllPermissions()
    {
        try {
            if (Gate::denies('permissions')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $items = Permission::latest()->get();

            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت مجوز ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            if (Gate::denies('view-permissions')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $item = Permission::findOrFail($id);
            return response()->json($item);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'مجوز ها یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت مجوز ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

}
