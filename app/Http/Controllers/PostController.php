<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class PostController extends Controller
{

    /**
     * @OA\Get(
     *     path="/posts",
     *     summary="List all posts",
     *     description="این متد لیست تمامی پست‌ها را بازمی‌گرداند.",
     *     operationId="getPosts",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *         ),
     *         description="توکن احراز هویت به صورت Bearer Token"
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"published", "draft"},
     *             example="published"
     *         ),
     *         description="نوع پست‌ها (منتشر شده یا پیش‌نویس)"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="لیست پست‌ها.",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="pagination", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت پست‌ها با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/posts/{id}",
     *     summary="Get a specific post",
     *     description="این متد یک پست خاص را بر اساس ID بازمی‌گرداند.",
     *     operationId="getPost",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *         ),
     *         description="توکن احراز هویت به صورت Bearer Token"
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         ),
     *         description="شناسه پست"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="اطلاعات پست.",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="پست یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="پست یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت پست با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/posts",
     *     summary="Create a new post",
     *     description="این متد یک پست جدید ایجاد می‌کند.",
     *     operationId="storePost",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *         ),
     *         description="توکن احراز هویت به صورت Bearer Token"
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="عنوان پست"
     *         ),
     *         description="عنوان پست"
     *     ),
     *     @OA\Parameter(
     *         name="content",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="محتوای پست"
     *         ),
     *         description="محتوای اصلی پست"
     *     ),
     *     @OA\Parameter(
     *         name="featured_image",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="image.jpg"
     *         ),
     *         description="تصویر اصلی پست (اختیاری)"
     *     ),
     *     @OA\Parameter(
     *         name="is_published",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="boolean",
     *             example=true
     *         ),
     *         description="آیا پست منتشر شده است؟"
     *     ),
     *     @OA\Parameter(
     *         name="categories",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(type="integer"),
     *             example={1, 2, 3}
     *         ),
     *         description="لیست شناسه دسته‌بندی‌ها"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="پست با موفقیت ایجاد شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="پست با موفقیت ایجاد شد."),
     *             @OA\Property(property="post", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="اعتبارسنجی شکست خورد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعتبارسنجی شکست خورد."),
     *             @OA\Property(property="details", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="ایجاد پست با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="ایجاد پست با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
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
                'province_id' => 'nullable|exists:provinces,id'
            ])->validate();

            $validated['published_at'] = now();
            $validated['user_id'] = $request->user()->id;

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

    /**
     * @OA\Put(
     *     path="/posts/{id}",
     *     summary="Update an existing post",
     *     description="این متد یک پست موجود را به‌روزرسانی می‌کند.",
     *     operationId="updatePost",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *         ),
     *         description="توکن احراز هویت به صورت Bearer Token"
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         ),
     *         description="شناسه پست برای به‌روزرسانی"
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="عنوان جدید پست"
     *         ),
     *         description="عنوان جدید پست"
     *     ),
     *     @OA\Parameter(
     *         name="content",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="محتوای جدید پست"
     *         ),
     *         description="محتوای به‌روزرسانی شده"
     *     ),
     *     @OA\Parameter(
     *         name="featured_image",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="image.jpg"
     *         ),
     *         description="تصویر جدید پست (اختیاری)"
     *     ),
     *     @OA\Parameter(
     *         name="is_published",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="boolean",
     *             example=true
     *         ),
     *         description="آیا پست منتشر شده است؟"
     *     ),
     *     @OA\Parameter(
     *         name="categories",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(type="integer"),
     *             example={1, 2, 3}
     *         ),
     *         description="لیست شناسه دسته‌بندی‌ها"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="پست با موفقیت به‌روزرسانی شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="پست با موفقیت به‌روزرسانی شد."),
     *             @OA\Property(property="post", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="پست یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="پست یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="اعتبارسنجی شکست خورد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعتبارسنجی شکست خورد."),
     *             @OA\Property(property="details", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="به‌روزرسانی پست با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="به‌روزرسانی پست با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
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
                'province_id' => 'nullable|exists:provinces,id'
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

    /**
     * @OA\Delete(
     *     path="/posts/{id}",
     *     summary="Delete a post",
     *     description="این متد یک پست را حذف می‌کند.",
     *     operationId="deletePost",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *         ),
     *         description="توکن احراز هویت به صورت Bearer Token"
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         ),
     *         description="شناسه پست برای حذف"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="پست با موفقیت حذف شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="پست با موفقیت حذف شد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="پست یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="پست یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="حذف پست با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="حذف پست با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/posts/published",
     *     summary="Get all published posts",
     *     description="این متد تمامی پست‌های منتشر شده را بازمی‌گرداند.",
     *     operationId="publishedPosts",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *         ),
     *         description="توکن احراز هویت به صورت Bearer Token"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="لیست پست‌های منتشر شده.",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="pagination", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت پست‌های منتشر شده با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
    public function published()
    {
        try {
            $posts = Post::published()->with(['user', 'categories'])->paginate(10);
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت پست‌های منتشرشده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/posts/draft",
     *     summary="Get all draft posts",
     *     description="این متد تمامی پست‌های پیش‌نویس را بازمی‌گرداند.",
     *     operationId="draftPosts",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *         ),
     *         description="توکن احراز هویت به صورت Bearer Token"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="لیست پست‌های پیش‌نویس.",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="pagination", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت پست‌های پیش‌نویس با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/posts/front-all-posts",
     *     summary="Get all published posts for the front-end",
     *     description="این متد تمامی پست‌های منتشر شده را برای بخش فرانت‌اند بازمی‌گرداند.",
     *     operationId="frontAllPosts",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="لیست پست‌های منتشر شده.",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="pagination", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت پست‌های منتشر شده با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
    public function frontAllPosts(Request $request)
    {
        try {
            $query = Post::published()->with(['categories']);
            if ($request->filled('province')) {
                $query->where('province_id', $request->province);
            }
            $posts = $query->paginate(10);
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت پست‌های منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/posts/front-single-post",
     *     summary="Get a single published post for the front-end",
     *     description="این متد یک پست منتشر شده را با استفاده از شناسه بازمی‌گرداند.",
     *     operationId="frontSinglePost",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="my-post-title"
     *         ),
     *         description="شناسه یا اسلاگ پست"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="اطلاعات پست منتشر شده.",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت پست‌ منتشر شده با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
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
