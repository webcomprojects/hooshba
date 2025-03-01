<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Committee;
use App\Models\Province;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCommitteeController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('committees.index');
        $committees = Committee::latest()->paginate(15);
        return view('back.committees.index', compact('committees'));
    }

    public function categories()
    {
        $cats=Category::where('type','committee')->orderBy('ordering','asc')->get()->toArray();
        $categories=categoriesBuildTree($cats);
        return view('back.categories.index',compact('categories'));
    }

    public function create()
    {
        $this->authorize('committees.create');
        $categories = Category::where('type', 'committee')->orderBy('ordering','asc')->get();
        $provinces=Province::latest()->Published()->get();
        return view('back.committees.create', compact('categories','provinces'));
    }



    public function store(Request $request)
    {
        $this->authorize('committees.create');

        if ($request->input('slug')) {
            $slug = sluggable_helper_function($request->slug);
        } else {
            $slug = sluggable_helper_function($request->name);
        }

        $request->merge(['slug' => $slug]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email',
            'phone' => 'required|digits:11|regex:/^[0][9][0-9]{9,9}$/',
            'content' => 'required|string',
            'slug' => 'nullable|string|unique:committees,slug',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'video' => 'nullable|string',
            'meta_title' => 'nullable||string|max:255',
            'meta_description' => 'nullable||string|max:2048',
            'tags' => 'nullable|array',
            'is_published' => 'nullable|boolean|in:0,1',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'province_id' => 'nullable|exists:provinces,id'
        ]);


        $imagePath=null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request);
        }

        $committee = Committee::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'slug' => $request->slug,
            'email' => $request->email,
            'phone' => $request->phone,
            'content' => $request->content,
            'video' => $request->video,
            'image' => $imagePath,
            'is_published' => $request->is_published ? 1 : 0,
            'published_at'=> now(),
            'province_id' => $request->province_id,
        ]);

        if ($request->categories) {
            $committee->categories()->sync($request->categories);
        }

        // if ($request->tags) {
        //     $tags = [];
        //     foreach ($request->tags as $tagName) {
        //         $tag = Tag::firstOrCreate(
        //             ['name' => $tagName],
        //             ['slug' => sluggable_helper_function($tagName)]
        //         );
        //         $tags[] = $tag->id;
        //     }
        //     $committee->tags()->sync($tags);
        // }

        toastr()->success('کمیته با موفیت ایجاد شد');
        return redirect()->route('back.committees.index');
    }

    public function edit(Committee $committee)
    {
        $this->authorize('committees.update');
        $categories = Category::where('type', 'committee')->orderBy('ordering','asc')->get();
        $provinces=Province::latest()->Published()->get();
        return view('back.committees.edit', compact('committee','categories','provinces'));
    }


    public function update(Request $request, Committee $committee)
    {

        $this->authorize('committees.update');


        if ($request->input('slug')) {
            $slug = sluggable_helper_function($request->slug);
        } else {
            $slug = sluggable_helper_function($request->name);
        }

        $request->merge(['slug' => $slug]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email',
            'phone' => 'required|digits:11|regex:/^[0][9][0-9]{9,9}$/',
            'content' => 'required|string',
            'slug' => 'nullable|string|unique:committees,slug,'.$committee->id,
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'video' => 'nullable|string',
            'is_published' => 'nullable|boolean|in:0,1',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'province_id' => 'nullable|exists:provinces,id'
        ]);


        $imagePath=$committee->image;
        if ($request->hasFile('image')) {

            if (!empty($committee->image) && file_exists(public_path($committee->image))) {
                if (is_file(public_path($committee->image))) {
                    unlink(public_path($committee->image));
                }
            }

            $imagePath = $this->uploadImage($request);
        }

        $committee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'content' => $request->content,
            'slug' =>$request->slug,
            'video' => $request->video,
            'image' => $imagePath,
            'is_published' => $request->is_published ? 1 : 0,
            'published_at'=> now(),
            'province_id' => $request->province_id,
        ]);

        if ($request->categories) {
            $committee->categories()->sync($request->categories);
        }

        // if ($request->tags) {
        //     $tags = [];
        //     foreach ($request->tags as $tagName) {
        //         $tag = Tag::firstOrCreate(
        //             ['name' => $tagName],
        //             ['slug' => sluggable_helper_function($tagName)]
        //         );
        //         $tags[] = $tag->id;
        //     }
        //     $committee->tags()->sync($tags);
        // }

        toastr()->success('کمیته با موفیت بروزرسانی شد');
        return redirect()->route('back.committees.index');
    }

    public function destroy(Committee $committee)
    {
        $this->authorize('committees.delete');

        // بررسی و حذف تصویر ویژه
        if (!empty($committee->image) && file_exists(public_path($committee->image))) {
            if (is_file(public_path($committee->image))) {
                unlink(public_path($committee->image));
            }
        }

        // بررسی و حذف ویدیو
        if (!empty($committee->video) && file_exists(public_path($committee->video))) {
            if (is_file(public_path($committee->video))) {
                unlink(public_path($committee->video));
            }
        }

        // حذف پست
        $committee->delete();
        toastr()->success('کمیته با موفقیت حذف شد');

        return redirect()->route('back.committees.index');
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
            $role = Committee::find($id['ids']);
            $this->destroy($role, true);
        }
        toastr()->success('کمیته ها با موفقیت حذف شدند');

        return redirect()->route('back.committees.index');
    }

    private function uploadImage(Request $request, $inputName = 'image')
    {

        if (!$request->hasFile($inputName)) {
            return null;
        }

        $file = $request->file($inputName);

        $validated = $request->validate([
            $inputName => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        /*$fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('uploads/images', $fileName, 'public');
            return '/storage/' . $filePath;*/

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // ذخیره فایل در مسیر public/uploads/images
        $filePath = 'storage/uploads/images/committees/' . $fileName;
        $file->move(public_path('storage/uploads/images/committees'), $fileName);

        // بازگشت مسیر فایل ذخیره شده
        return '/storage/uploads/images/committees/' . $fileName;
    }

    private function uploadVideo(Request $request, $inputName = 'video')
    {
        try {
            if (!$request->hasFile($inputName)) {
                return null;
            }

            $file = $request->file($inputName);

            $validated = $request->validate([
                $inputName => 'file|mimes:mp4,avi,mov|max:51200',
            ]);

            /*$fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('uploads/images', $fileName, 'public');
            return '/storage/' . $filePath;*/

            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            // ذخیره فایل در مسیر public/uploads/images
            $filePath = 'storage/uploads/videos/' . $fileName;
            $file->move(public_path('storage/uploads/videos'), $fileName);

            // بازگشت مسیر فایل ذخیره شده
            return '/storage/uploads/videos/' . $fileName;
        } catch (\Exception $e) {
            throw new \Exception('آپلود ویدیو با شکست مواجه شد: ' . $e->getMessage());
        }
    }

    public function get_tags(Request $request)
    {
        $tags = Tag::detectLang()->where('name', 'like', '%' . $request->term . '%')
            ->latest()
            ->take(5)
            ->pluck('name')
            ->toArray();

        return response()->json($tags);
    }


}
