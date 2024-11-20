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
            return response()->json(['error' => 'Failed to fetch posts', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $post = Post::with(['user', 'categories'])->findOrFail($id);
            return response()->json($post);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Post not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch post', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // اعتبارسنجی ورودی‌ها
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'featured_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // بهینه‌تر برای مدیریت فایل‌ها
                'is_published' => 'boolean',
                'published_at' => 'nullable|date',
                'categories' => 'nullable|array',
                'categories.*' => 'exists:categories,id',
            ]);

            $validated['slug'] = Str::slug($validated['title'], '-');

            $validated['user_uuid'] = $request->user()->uuid;

            if ($request->hasFile('featured_image')) {
                $imagePath = $this->uploadImage($request);
                $validated['featured_image'] = $imagePath;
            }

            $post = Post::create($validated);

            if (!empty($validated['categories'])) {
                $post->categories()->sync($validated['categories']);
            }

            return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create post', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'content' => 'sometimes|string',
                'slug' => 'sometimes|string|unique:posts,slug,' . $id,
                'featured_image' => 'nullable|string',
                'is_published' => 'boolean',
                'published_at' => 'nullable|date',
                'categories' => 'nullable|array',
                'categories.*' => 'exists:categories,id',
            ]);

            $post = Post::findOrFail($id);
            $post->update($validated);

            if (isset($validated['categories'])) {
                $post->categories()->sync($validated['categories']);
            }

            return response()->json($post);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Post not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update post', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();

            return response()->json(['message' => 'Post deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Post not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete post', 'message' => $e->getMessage()], 500);
        }
    }

    public function published()
    {
        try {
            $posts = Post::published()->with(['user', 'categories'])->paginate(10);
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch published posts', 'message' => $e->getMessage()], 500);
        }
    }

    public function draft()
    {
        try {
            $posts = Post::draft()->with(['user', 'categories'])->paginate(10);
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch draft posts', 'message' => $e->getMessage()], 500);
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
            throw new \Exception('Failed to upload image: ' . $e->getMessage());
        }
    }
}
