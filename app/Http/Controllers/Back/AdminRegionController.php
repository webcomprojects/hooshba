<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class AdminRegionController extends Controller
{
    public function index()
    {
        $this->authorize('regions.index');
        $regions=Region::latest()->paginate(20);
        return view('back.regions.index',compact('regions'));
    }

    public function create()
    {
        $this->authorize('regions.create');
        return view('back.regions.create');
    }

    public function store(Request $request)
    {
        $this->authorize('regions.create');
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:regions,slug',
            'is_published' => 'nullable|boolean|in:0,1',
        ]);
        $slug = sluggable_helper_function($request->name);
         Region::create([
            'name' => $request->name,
            'slug' =>$slug,
            'is_published' => $request->is_published ? 1 : 0,
            'published_at'=> now(),
        ]);

        toastr()->success('منطقه با موفیت ایجاد شد');
        return redirect()->route('back.regions.index');
    }
    public function edit(Region $region)
    {
        $this->authorize('regions.update');
        return view('back.regions.edit',compact('region'));
    }

    public function update(Region $region,Request $request)
    {
        $this->authorize('regions.update');
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:regions,slug,'.$region->id,
            'is_published' => 'nullable|boolean|in:0,1',
        ]);
        $slug = sluggable_helper_function($request->name);
        $region->update([
            'name' => $request->name,
            'slug' =>$slug,
            'is_published' => $request->is_published ? 1 : 0,
            'published_at'=> now(),
        ]);

        toastr()->success('منطقه با موفیت ویرایش شد');
        return redirect()->route('back.regions.index');
    }
    public function destroy(Region $region)
    {
        $this->authorize('regions.delete');
        $region->delete();
        toastr()->success('منطقه با موفقیت حذف شد');

        return redirect()->route('back.regions.index');
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
            $role = Region::find($id['ids']);
            $this->destroy($role, true);
        }
        toastr()->success('مناطق با موفقیت حذف شدند');

        return redirect()->route('back.regions.index');
    }

}
