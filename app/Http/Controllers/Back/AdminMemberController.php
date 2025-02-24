<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMemberController extends Controller
{
    public function index()
    {
        $this->authorize('members.index');
        $members = Member::latest()->paginate(20);
        return view('back.members.index', compact('members'));
    }

    public function create()
    {
        $this->authorize('members.create');
        $provinces=Province::Published()->get();
        return view('back.members.create',compact('provinces'));
    }

    public function store(Request $request)
    {
        $this->authorize('members.create');

        if ($request->input('slug')) {
            $slug = sluggable_helper_function($request->slug);
        } else {
            $slug = sluggable_helper_function($request->title);
        }
        $request->merge(['slug' => $slug]);

        $request->validate([
            'slug' => 'nullable|string|unique:members,slug',
            'type' => 'required|in:council,presidency',
            'name' => 'required|string|max:255',
            'job_position' => 'nullable|array',
            'email' => 'required|string|max:255|email',
            'mobile' => 'required|digits:11|regex:/^[0][9][0-9]{9,9}$/',
            'links' => 'nullable|array',
            'description' => 'nullable|string',
            'image' =>  'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'educational_background' => 'required|max:1024',
            'executive_background' => 'required|max:1024',
            'province_id' => 'nullable|exists:provinces,id',
            'is_published' => 'nullable|boolean|in:0,1',
        ],[
            'educational_background.required'=>'فیلد سوابق تحصیلی الزامی است.',
            'executive_background.required'=>'فیلد سوابق شغلی الزامی است.',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request);
        }

        Member::create([
            'user_id' => Auth::id(),
            'slug' => $request->slug,
            'type' => $request->type,
            'name' => $request->name,
            'job_position' => $request->job_position,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'links' => $request->links,
            'description' => $request->description,
            'educational_background' => $request->educational_background,
            'executive_background' => $request->executive_background,
            'province_id' => $request->province_id,
            'image' => $imagePath,
            'is_published' => $request->is_published ? 1 : 0,
            'published_at' => now(),
        ]);

        toastr()->success('عضو جدید با موفیت اضافه شد');
        return redirect()->route('back.members.index');
    }
    public function edit(Province $province)
    {
        $this->authorize('members.update');
        $regions = Region::latest()->published()->get();
        return view('back.members.edit', compact('province', 'regions'));
    }

    public function update(Province $province, Request $request)
    {
        $this->authorize('members.update');
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:members,slug,' . $province->id,
            'is_published' => 'nullable|boolean|in:0,1',
            'region_id' => 'nullable|exists:regions,id'
        ]);
        $slug = sluggable_helper_function($request->name);
        $province->update([
            'name' => $request->name,
            'slug' => $slug,
            'region_id' => $request->region_id,
            'is_published' => $request->is_published ? 1 : 0,
            'published_at' => now(),
        ]);

        toastr()->success('استان با موفیت ویرایش شد');
        return redirect()->route('back.members.index');
    }
    public function destroy(Province $province)
    {
        $this->authorize('members.delete');
        $province->delete();
        toastr()->success('استان با موفیت حذف شد');

        return redirect()->route('back.members.index');
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
        toastr()->success('مناطق با موفیت حذف شدند');

        return redirect()->route('back.members.index');
    }

    private function uploadImage(Request $request, $inputName = 'featured_image')
    {

        if (!$request->hasFile($inputName)) {
            return null;
        }

        $file = $request->file($inputName);

        $validated = $request->validate([
            $inputName => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        /*$fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('uploads/images', $fileName, 'public');
            return '/storage/' . $filePath;*/

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        mkdir('storage/uploads/images/members');
        // ذخیره فایل در مسیر public/uploads/images
        $filePath = 'storage/uploads/images/members' . $fileName;
        $file->move(public_path('storage/uploads/images/members'), $fileName);

        // بازگشت مسیر فایل ذخیره شده
        return '/storage/uploads/images/members/' . $fileName;
    }
}
