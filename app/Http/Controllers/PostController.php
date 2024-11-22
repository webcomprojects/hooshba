<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        try {
            $type = $request->query('type');
            $query = Post::with(['user', 'categories']);

            if ($type === 'published') {
                $query->published();
            } elseif ($type === 'draft') {
                $query->draft();
            }

            $posts = $query->paginate(10);

            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت پست‌ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $post = Post::with(['user', 'categories'])->findOrFail($id);
            return response()->json($post);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'پست یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت پست با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $slug = Str::slug($request->title, '-');
        $data = array_merge($request->all(), ['slug' => $slug]);

        try {
            $validated = validator($data, [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'slug' => 'required|string|unique:posts,slug',
                'featured_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'is_published' => 'boolean',
                'categories' => 'nullable|array',
                'categories.*' => 'exists:categories,id',
            ])->validate();

            $validated['published_at'] = now();
            $validated['user_uuid'] = $request->user()->uuid;

            if ($request->hasFile('featured_image')) {
                $imagePath = $this->uploadImage($request);
                $validated['featured_image'] = $imagePath;
            }

            $post = Post::create($validated);

            if (!empty($validated['categories'])) {
                $post->categories()->sync($validated['categories']);
            }

            return response()->json(['message' => 'پست با موفقیت ایجاد شد.', 'post' => $post], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'ایجاد پست با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $slug = Str::slug($request->title, '-');
        $data = array_merge($request->all(), ['slug' => $slug]);

        try {
            $validated = validator($data, [
                'title' => 'sometimes|string|max:255',
                'content' => 'sometimes|string',
                'slug' => 'sometimes|string|unique:posts,slug,' . $id,
                'featured_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'is_published' => 'boolean',
                'categories' => 'nullable|array',
                'categories.*' => 'exists:categories,id',
            ])->validate();

            $post = Post::findOrFail($id);

            if ($request->hasFile('featured_image')) {
                $imagePath = $this->uploadImage($request);
                $validated['featured_image'] = $imagePath;
            }

            $post->update($validated);

            if (isset($validated['categories'])) {
                $post->categories()->sync($validated['categories']);
            }

            return response()->json(['message' => 'پست با موفقیت به‌روزرسانی شد.', 'post' => $post]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'پست یافت نشد.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'به‌روزرسانی پست با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();

            return response()->json(['message' => 'پست با موفقیت حذف شد.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'پست یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حذف پست با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    public function published()
    {
        try {
            $posts = Post::published()->with(['user', 'categories'])->paginate(10);
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت پست‌های منتشرشده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    public function draft()
    {
        try {
            $posts = Post::draft()->with(['user', 'categories'])->paginate(10);
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت پست‌های پیش‌نویس با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    private function uploadImage(Request $request, $inputName = 'featured_image')
    {
        try {
            if (!$request->hasFile($inputName)) {
                return null;
            }

            $file = $request->file($inputName);

            $validated = $request->validate([
                $inputName => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('uploads/images', $fileName, 'public');

            return '/storage/' . $filePath;
        } catch (\Exception $e) {
            throw new \Exception('آپلود تصویر با شکست مواجه شد: ' . $e->getMessage());
        }
    }

    public function frontAllPosts()
    {
        try {
            $posts = Post::published()->with(['categories'])->paginate(10);
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت پست‌های منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    public function frontSinglePost(Request $request)
    {
        try {
            $post = Post::SinglePostPublished($request->slug)->with(['categories'])->first();
            return response()->json($post);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت پست‌ منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }
}
