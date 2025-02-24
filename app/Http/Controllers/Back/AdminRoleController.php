<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRoleController extends Controller
{
    public function index()
    {
        $this->authorize('roles.index');
        $items=Role::paginate(10);
        return view('back.roles.index',compact('items'));
    }

    public function create()
    {
        $this->authorize('roles.create');
        $items=Permission::whereNull('permission_id')->get();
        return view('back.roles.create',compact('items'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $role=new Role();
        $role->title=$request->title;
        $role->description=$request->description;
        $role->slug=sluggable_helper_function($request->title);
        $role->save();
        $role->permissions()->attach($request->permissions);


        toastr()->success('مقام با موفقیت ایجاد شد');
        return redirect()->route('back.roles.index');

    }


    public function edit(Role $role)
    {
        $this->authorize('roles.update');
        $items=Permission::whereNull('permission_id')->get();
        return view('back.roles.edit',compact('items','role'));
    }

    public function update(Request $request,Role $role)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $role->update([
            'title'       => $request->title,
            'description' => $request->description
        ]);

        $role->permissions()->sync($request->permissions);


        toastr()->success('مقام با موفقیت ویرایش شد');
        return redirect()->route('back.roles.index');

    }

    public function destroy(Role $role, $multiple = false)
    {
        $this->authorize('roles.delete');
        $role->delete();
        if (!$multiple) {
            toastr()->success('مقام با موفقیت حذف شد');
        }else{
            toastr()->success('مقام ها با موفقیت حذف شدند');
        }
        return redirect()->route('back.roles.index');
    }

    public function multipleDestroy(Request $request)
    {

        $ids=explode(',',$request->ids);
        $newArray = [];

        foreach ($ids as $id) {
            $newArray[] = ['ids' => $id];
        }

        $request->merge(['ids' => $newArray]);
        $request->validate([
            'ids'   => 'required|array',
        ]);

        foreach ($request->ids as $id) {
            $role = Role::find($id['ids']);
            $this->destroy($role, true);
        }
        return redirect()->route('back.roles.index');
    }
}
