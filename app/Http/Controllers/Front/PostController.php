<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use function App\Helpers\sluggable_helper_function;

class PostController extends Controller
{


    public function index(Request $request)
    {
        $categorySlug = $request->query('c'); // فیلتر دسته‌بندی
        $keyword = $request->query('k'); // فیلتر کلمه کلیدی
        $tagSlug = $request->query('tag'); // فیلتر تگ

        $query = Post::with(['user', 'categories', 'tags'])->published();

        // فیلتر بر اساس دسته‌بندی
        if ($categorySlug) {
            $query->whereHas('categories', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // فیلتر بر اساس کلمه کلیدی
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('content', 'LIKE', "%{$keyword}%");
            });
        }

        // فیلتر بر اساس تگ
        if ($tagSlug) {
            $query->whereHas('tags', function ($q) use ($tagSlug) {
                $q->where('slug', $tagSlug);
            });
        }

        $posts = $query->orderBy('created_at', 'desc')->published()->paginate(12);
        $last_posts = Post::with('categories')->orderBy('created_at', 'desc')->published()->take(4)->get();
        $categories = Category::get();
        $tags = Tag::get(); // دریافت همه تگ‌ها برای نمایش در سایدبار

        return view('front.blog.index', compact('posts', 'categories', 'tags', 'last_posts'));
    }


    public function show($slug)
    {
        $last_posts = Post::with('categories')->orderBy('created_at', 'desc')->take(4)->get();
        $categories = Category::get();
        $tags = Tag::get();
        $post = Post::with(['user', 'categories', 'tags'])->where('slug',$slug)->first();
        return view('front.blog.show',compact('post','categories', 'tags', 'last_posts'));
    }

    public function store(Request $request)
    {


        try {
            if (Gate::denies('create-posts')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }
            if ($request->has('slug')) {
                $data = $request->all();
            } else {
                $slug = sluggable_helper_function($request->title);
                $data = array_merge($request->all(), ['slug' => $slug]);
            }

            $validated = validator($data, [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'slug' => 'nullable|string|unique:posts,slug',
                'featured_image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
                'video' => 'nullable|string',
                'meta_title' => 'nullable||string|max:255',
                'meta_description' => 'nullable||string|max:2048',
                'tags' => 'nullable|array',
                'is_published' => 'required|boolean|in:0,1',
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

            if (!empty($validated['tags'])) {
                $tags = [];
                foreach ($validated['tags'] as $tagName) {
                    $tag = Tag::firstOrCreate(
                        ['name' => $tagName],
                        ['slug' => sluggable_helper_function($tagName)]
                    );
                    $tags[] = $tag->id;
                }
                $post->tags()->sync($tags);
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
        // بررسی داده‌های دریافتی


        try {
            if (Gate::denies('update-posts')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }
            if ($request->filled('slug')) {
                $data = $request->all();
            } else {
                $slug = sluggable_helper_function($request->title);
                $data = array_merge($request->all(), ['slug' => $slug]);
            }

            // اعتبارسنجی
            $validated = validator($data, [
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'slug' => 'nullable|string|unique:posts,slug,' . $id,
                'featured_image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
                'video' => 'nullable|string',
                'meta_title' => 'nullable||string|max:255',
                'meta_description' => 'nullable||string|max:2048',
                'tags' => 'nullable|array',
                'is_published' => 'nullable|boolean|in:0,1',
                'categories' => 'nullable|array',
                'categories.*' => 'exists:categories,id',
                'province_id' => 'nullable|exists:provinces,id'
            ])->validate();

            $post = Post::findOrFail($id);

            // آپلود تصویر
            if ($request->hasFile('featured_image')) {
                $imagePath = $this->uploadImage($request);
                $validated['featured_image'] = $imagePath;
            }

            // به‌روزرسانی پست
            $post->update($validated);

            // به‌روزرسانی دسته‌بندی‌ها
            if (isset($validated['categories'])) {
                $post->categories()->sync($validated['categories']);
            }
            if (!empty($validated['tags'])) {
                $tags = [];
                foreach ($validated['tags'] as $tagName) {
                    $tag = Tag::firstOrCreate(
                        ['name' => $tagName],
                        ['slug' => sluggable_helper_function($tagName)]
                    );
                    $tags[] = $tag->id;
                }
                $post->tags()->sync($tags);
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

            if (Gate::denies('delete-posts')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $post = Post::findOrFail($id);

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

            if (Gate::denies('posts')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }
            $posts = Post::published()->with(['user', 'categories'])->paginate(10);
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت پست‌های منتشرشده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    public function draft()
    {
        try {
            if (Gate::denies('posts')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }
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
        } catch (\Exception $e) {
            throw new \Exception('آپلود تصویر با شکست مواجه شد: ' . $e->getMessage());
        }
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
            $take = $request->input('take', 10);
            $posts = $query->paginate($take);
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
