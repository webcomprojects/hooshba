<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use function App\Helpers\sluggable_helper_function;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="List all categories",
     *     description="این متد لیست تمامی دسته‌بندی‌ها را بازمی‌گرداند.",
     *     operationId="getCategories",
     *     tags={"Categories"},
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
     *         description="لیست دسته‌بندی‌ها.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت دسته‌بندی‌ها با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            if (Gate::denies('categories')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }
            $query = Category::query();

            if ($request->has('type')) {
                if ($request->type === "member") {
                    $query->where('type', $request->type)->with('members');
                } elseif ($request->type === "post") {
                    $query->where('type', 'post')->with('posts');
                }
            } else {
                $query->with(['posts', 'members']);
            }

            $categories = $query->paginate(10);

            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت دسته‌بندی‌ها با شکست مواجه شد.'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/categories/{id}",
     *     summary="Get a specific category",
     *     description="این متد اطلاعات یک دسته‌بندی خاص را بازمی‌گرداند.",
     *     operationId="getCategory",
     *     tags={"Categories"},
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
     *         description="شناسه دسته‌بندی"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="اطلاعات دسته‌بندی.",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="دسته‌بندی یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دسته‌بندی یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت دسته‌بندی با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
    public function show(Request $request,$id)
    {
        try {
            if (Gate::denies('view-categories')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $category = Category::with('posts', 'members')->findOrFail($id);
            if ($request->has('type')) {
                if ($request->type === "member") {
                    $category = Category::with( 'members')->findOrFail($id);
                } elseif ($request->type === "post") {
                    $category = Category::with('posts')->findOrFail($id);
                }
            }

            return response()->json($category);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'دسته‌بندی یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت دسته‌بندی با شکست مواجه شد.'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/categories",
     *     summary="Create a new category",
     *     description="این متد یک دسته‌بندی جدید ایجاد می‌کند.",
     *     operationId="storeCategory",
     *     tags={"Categories"},
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
     *         name="name",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="دسته‌بندی جدید"
     *         ),
     *         description="نام دسته‌بندی"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="دسته‌بندی با موفقیت ایجاد شد.",
     *         @OA\JsonContent(type="object")
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
     *         description="ایجاد دسته‌بندی با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="ایجاد دسته‌بندی با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            if (Gate::denies('create-categories')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories',
                'type' => 'required|string|in:member,post',
                'parent_id' => 'nullable',
            ]);

            $validated['slug'] = $this->generateSlug($validated['name']);

            $category = Category::create($validated);

            return response()->json($category, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'ایجاد دسته‌بندی با شکست مواجه شد.'], 500);
        }
    }


    /**
     * @OA\Put(
     *     path="/categories/{id}",
     *     summary="Update an existing category",
     *     description="این متد یک دسته‌بندی موجود را به‌روزرسانی می‌کند.",
     *     operationId="updateCategory",
     *     tags={"Categories"},
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
     *         description="شناسه دسته‌بندی"
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="نام جدید دسته‌بندی"
     *         ),
     *         description="نام جدید دسته‌بندی"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="دسته‌بندی با موفقیت به‌روزرسانی شد.",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="دسته‌بندی یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دسته‌بندی یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="اعتبارسنجی شکست خورد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعتبارسنجی شکست خورد."),
     *             @OA\Property(property="details", type="object")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            if (Gate::denies('update-categories')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255|unique:categories,name,' . $id,
                'type' => 'required|string|in:member,post',
                'parent_id' => 'nullable',
            ]);

            $category = Category::findOrFail($id);

            if (isset($validated['name'])) {
                $validated['slug'] = $this->generateSlug($validated['name']);
            }

            $category->update($validated);

            return response()->json($category);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'دسته‌بندی یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'به‌روزرسانی دسته‌بندی با شکست مواجه شد.'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/categories/{id}",
     *     summary="Delete a category",
     *     description="این متد یک دسته‌بندی را حذف می‌کند.",
     *     operationId="deleteCategory",
     *     tags={"Categories"},
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
     *         description="شناسه دسته‌بندی"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="دسته‌بندی با موفقیت حذف شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="دسته‌بندی با موفقیت حذف شد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="دسته‌بندی یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دسته‌بندی یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="حذف دسته‌بندی با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="حذف دسته‌بندی با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            if (Gate::denies('delete-categories')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json(['message' => 'دسته‌بندی با موفقیت حذف شد.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'دسته‌بندی یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حذف دسته‌بندی با شکست مواجه شد.'], 500);
        }
    }

    private function generateSlug($name)
    {
        return  sluggable_helper_function($name);
    }


    /**
     * @OA\Get(
     *     path="/categories/front-all-categories",
     *     summary="Get all categories for the front-end",
     *     description="این متد تمامی دسته‌بندی‌ها را بازمی‌گرداند.",
     *     operationId="frontAllCategories",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="لیست دسته‌بندی‌ها.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت دسته بندی ها با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
    public function frontAllCategories(Request $request)
    {
        try {

            $query = Category::query();
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }
            $categories = $query->get();

            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت دسته بندی ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/categories/front-single-category",
     *     summary="Get a single category for the front-end",
     *     description="این متد اطلاعات یک دسته‌بندی را با استفاده از slug بازمی‌گرداند.",
     *     operationId="frontSingleCategory",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="category-slug"
     *         ),
     *         description="اسلاگ دسته‌بندی"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="اطلاعات دسته‌بندی.",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت دسته بندی ها با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
    public function frontSingleCategory(Request $request)
    {
        try {
            $categories = Category::with('posts','members')->where('slug', $request->slug)->first();
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت دسته بندی ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }
}
