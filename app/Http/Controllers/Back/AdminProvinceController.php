<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Http\Request;

class AdminProvinceController extends Controller
{
    public function index()
    {
        $this->authorize('provinces.index');
        $provinces=Province::latest()->paginate(20);
        return view('back.provinces.index',compact('provinces'));
    }

    public function create()
    {
        $this->authorize('provinces.create');
        $regions=Region::latest()->published()->get();
        return view('back.provinces.create',compact('regions'));
    }

    public function store(Request $request)
    {
        $this->authorize('provinces.create');
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:Provinces,slug',
            'is_published' => 'nullable|boolean|in:0,1',
            'region_id' => 'nullable|exists:regions,id'
        ]);
        $slug = sluggable_helper_function($request->name);
         Province::create([
            'name' => $request->name,
            'region_id' => $request->region_id,
            'slug' =>$slug,
            'is_published' => $request->is_published ? 1 : 0,
            'published_at'=> now(),
        ]);

        toastr()->success('استان با موفیت ایجاد شد');
        return redirect()->route('back.provinces.index');
    }
    public function edit(Province $province)
    {
        $this->authorize('provinces.update');
        $regions=Region::latest()->published()->get();
        return view('back.provinces.edit',compact('province','regions'));
    }

    public function update(Province $province,Request $request)
    {
        $this->authorize('provinces.update');
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:provinces,slug,'.$province->id,
            'is_published' => 'nullable|boolean|in:0,1',
            'region_id' => 'nullable|exists:regions,id'
        ]);
        $slug = sluggable_helper_function($request->name);
        $province->update([
            'name' => $request->name,
            'slug' =>$slug,
            'region_id' =>$request->region_id,
            'is_published' => $request->is_published ? 1 : 0,
            'published_at'=> now(),
        ]);

        toastr()->success('استان با موفیت ویرایش شد');
        return redirect()->route('back.provinces.index');
    }
    public function destroy(Province $province)
    {
        $this->authorize('provinces.delete');
        $province->delete();
        toastr()->success('استان با موفقیت حذف شد');

        return redirect()->route('back.provinces.index');
    }

    public function multipleDestroy(Request $request)
    {

        $ids = explode(',', $request->ids);
        $newArray = [];

        foreach ($ids as $id) {
            $newArray[] = ['ids' => $id];
        }

        $request->merge(['ids' => $newArray]);
        $request->validate([
            'ids'   => 'required|array',
        ]);

        foreach ($request->ids as $id) {
            $role = Province::find($id['ids']);
            $this->destroy($role, true);
        }
        toastr()->success('مناطق با موفقیت حذف شدند');

        return redirect()->route('back.provinces.index');
    }

}
