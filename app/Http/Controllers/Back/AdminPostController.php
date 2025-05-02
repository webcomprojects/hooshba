<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Province;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{


    public function index(Request $request)
    {
        $this->authorize('posts.index');
        $posts = Post::latest()->paginate(15);
        return view('back.posts.index', compact('posts'));
    }

    public function categories()
    {
        $cats = Category::where('type', 'post')->orderBy('ordering', 'asc')->get()->toArray();
        $categories = categoriesBuildTree($cats);
        return view('back.categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorize('posts.create');
        $categories = Category::where('type', 'post')->orderBy('ordering', 'asc')->get();
        $provinces = Province::latest()->Published()->get();
        return view('back.posts.create', compact('categories', 'provinces'));
    }

    public function show($slug)
    {
        $last_posts = Post::with('categories')->orderBy('created_at', 'desc')->take(4)->get();
        $categories = Category::get();
        $tags = Tag::get();
        $post = Post::with(['user', 'categories', 'tags'])->where('slug', $slug)->first();
        return view('front.blog.show', compact('post', 'categories', 'tags', 'last_posts'));
    }

    public function store(Request $request)
    {
        $this->authorize('posts.create');

        if ($request->input('slug')) {
            $slug = sluggable_helper_function($request->slug);
        } else {
            $slug = sluggable_helper_function($request->title);
        }

        $request->merge(['slug' => $slug]);

        if ($request->input('tags')) {
            $tags = explode(',', $request->input('tags'));
            $request->merge(['tags' => $tags]);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|unique:posts,slug',
            'featured_image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'video' => 'nullable|string',
            'meta_title' => 'nullable||string|max:255',
            'meta_description' => 'nullable||string|max:2048',
            'tags' => 'nullable|array',
            'is_published' => 'nullable|boolean|in:0,1',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'province_id' => 'nullable|exists:provinces,id'
        ]);


        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $this->uploadImage($request);
        }

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'video' => $request->video,
            'featured_image' => $imagePath,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_published' => $request->is_published ? 1 : 0,
            'published_at' => now(),
            'province_id' => $request->province_id,
        ]);

        if ($request->categories) {
            $post->categories()->sync($request->categories);
        }

        if ($request->tags) {
            $tags = [];
            foreach ($request->tags as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => sluggable_helper_function($tagName)]
                );
                $tags[] = $tag->id;
            }
            $post->tags()->sync($tags);
        }

        toastr()->success('مقاله با موفیت ایجاد شد');
        return redirect()->route('back.posts.index');
    }

    public function edit(Post $post)
    {
        $this->authorize('posts.update');
        $categories = Category::where('type', 'post')->orderBy('ordering', 'asc')->get();
        $provinces = Province::latest()->Published()->get();
        return view('back.posts.edit', compact('post', 'categories', 'provinces'));
    }


    public function update(Request $request, Post $post)
    {

        $this->authorize('posts.update');


        if ($request->input('slug')) {
            $slug = sluggable_helper_function($request->slug);
        } else {
            $slug = sluggable_helper_function($request->title);
        }

        $request->merge(['slug' => $slug]);

        if ($request->input('tags')) {
            $tags = explode(',', $request->input('tags'));
            $request->merge(['tags' => $tags]);
        }


        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|unique:posts,slug,' . $post->id,
            'featured_image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'video' => 'nullable|string',
            'meta_title' => 'nullable||string|max:255',
            'meta_description' => 'nullable||string|max:2048',
            'tags' => 'nullable|array',
            'is_published' => 'nullable|boolean|in:0,1',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'province_id' => 'nullable|exists:provinces,id'
        ]);


        $imagePath = $post->featured_image;
        if ($request->hasFile('featured_image')) {

            if (!empty($post->featured_image) && file_exists(public_path($post->featured_image))) {
                if (is_file(public_path($post->featured_image))) {
                    unlink(public_path($post->featured_image));
                }
            }

            $imagePath = $this->uploadImage($request);
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'video' => $request->video,
            'featured_image' => $imagePath,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_published' => $request->is_published ? 1 : 0,
            'published_at' => now(),
            'province_id' => $request->province_id,
        ]);

        if ($request->categories) {
            $post->categories()->sync($request->categories);
        }

        if ($request->tags) {
            $tags = [];
            foreach ($request->tags as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => sluggable_helper_function($tagName)]
                );
                $tags[] = $tag->id;
            }
            $post->tags()->sync($tags);
        }

        toastr()->success('مقاله با موفیت بروزرسانی شد');
        return redirect()->route('back.posts.index');
    }

    public function destroy(Post $post)
    {
        $this->authorize('posts.delete');

        // بررسی و حذف تصویر ویژه
        if (!empty($post->featured_image) && file_exists(public_path($post->featured_image))) {
            if (is_file(public_path($post->featured_image))) {
                unlink(public_path($post->featured_image));
            }
        }

        // بررسی و حذف ویدیو
        if (!empty($post->video) && file_exists(public_path($post->video))) {
            if (is_file(public_path($post->video))) {
                unlink(public_path($post->video));
            }
        }

        // حذف پست
        $post->delete();
        toastr()->success('مقاله با موفقیت حذف شد');

        return redirect()->route('back.posts.index');
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
            $role = Post::find($id['ids']);
            $this->destroy($role, true);
        }
        toastr()->success('مقالات با موفقیت حذف شدند');

        return redirect()->route('back.posts.index');
    }

    private function uploadImage(Request $request, $inputName = 'featured_image')
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
        $filePath = 'storage/uploads/images/' . $fileName;
        $file->move(public_path('storage/uploads/images'), $fileName);

        // بازگشت مسیر فایل ذخیره شده
        return '/storage/uploads/images/' . $fileName;
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
