<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use function App\Helpers\sluggable_helper_function;

class ProvinceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/provinces",
     *     summary="دریافت لیست استان‌ها",
     *     description="دریافت لیست استان‌ها با امکان فیلتر براساس وضعیت (منتشرشده یا پیش‌نویس)",
     *     operationId="getProvinces",
     *     tags={"Provinces"},
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="فیلتر براساس وضعیت استان‌ها (منتشرشده یا پیش‌نویس)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"published", "draft"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="لیست استان‌ها با موفقیت دریافت شد",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="slug", type="string"),
     *                     @OA\Property(property="is_published", type="boolean"),
     *                     @OA\Property(property="posts", type="array", @OA\Items(type="object")),
     *                     @OA\Property(property="committees", type="array", @OA\Items(type="object")),
     *                     @OA\Property(property="users", type="array", @OA\Items(type="object"))
     *                 )
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت استان‌ها با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            if (Gate::denies('provinces')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $type = $request->query('type');
            $query = Province::with(['posts','committees','users','members']);

            if ($type === 'published') {
                $query->published();
            } elseif ($type === 'draft') {
                $query->draft();
            }

            $provinces = $query->paginate(10);

            return response()->json($provinces);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت استان‌ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/provinces/{id}",
     *     summary="دریافت اطلاعات یک استان",
     *     description="دریافت اطلاعات یک استان خاص با تمامی پست‌ها، کمیته‌ها و کاربران مرتبط",
     *     operationId="getProvinceById",
     *     tags={"Provinces"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="شناسه استان",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="اطلاعات استان با موفقیت دریافت شد",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="slug", type="string"),
     *             @OA\Property(property="is_published", type="boolean"),
     *             @OA\Property(property="posts", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="committees", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="users", type="array", @OA\Items(type="object"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="استان یافت نشد",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="استان یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت استان با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            if (Gate::denies('view-provinces')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $province = Province::with(['posts','committees','users','members'])->findOrFail($id);
            return response()->json($province);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'استان یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت استان با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/provinces",
     *     summary="ایجاد یک استان جدید",
     *     description="این متد یک استان جدید ایجاد می‌کند و به صورت خودکار slug را بر اساس نام استان تولید می‌کند.",
     *     operationId="storeProvince",
     *     tags={"Provinces"},
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
     *             example="تهران"
     *         ),
     *         description="نام استان"
     *     ),
     *     @OA\Parameter(
     *         name="slug",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="tehran"
     *         ),
     *         description="شناسه یکتا برای استان (به صورت خودکار تولید می‌شود، ارسال این مقدار اختیاری است)."
     *     ),
     *     @OA\Parameter(
     *         name="ordering",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         ),
     *         description="ترتیب نمایش استان‌ها (اختیاری)"
     *     ),
     *     @OA\Parameter(
     *         name="is_published",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="boolean",
     *             example=true
     *         ),
     *         description="وضعیت انتشار استان (منتشر شده یا خیر)"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="استان با موفقیت ایجاد شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="استان با موفقیت ایجاد شد."),
     *             @OA\Property(property="province", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="تهران"),
     *                 @OA\Property(property="slug", type="string", example="tehran"),
     *                 @OA\Property(property="ordering", type="integer", example=1),
     *                 @OA\Property(property="is_published", type="boolean", example=true),
     *                 @OA\Property(property="published_at", type="string", format="date-time", example="2024-12-16T12:00:00")
     *             )
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
     *         description="ایجاد استان با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="ایجاد استان با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */


    public function store(Request $request)
    {

        try {
            if (Gate::denies('create-provinces')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }
            $slug = sluggable_helper_function($request->name);
            $data = array_merge($request->all(), ['slug' => $slug]);


            $validated = validator($data, [
                'slug' => 'nullable|string|unique:provinces,slug',
                'name' => 'required|string|max:255',
                'ordering' => 'nullable|integer',
                'region_id ' => 'required|exists:regions,id',
                'is_published' => 'required|boolean|in:0,1',
            ])->validate();

            $validated['published_at'] = now();
            if (empty($validated['ordering'])) {
                $validated['ordering'] = Province::max('ordering') + 1;
            }
            $province = Province::create($validated);

            return response()->json(['message' => 'استان با موفقیت ایجاد شد.', 'province' => $province], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'ایجاد استان با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/provinces/{id}",
     *     summary="به‌روزرسانی استان",
     *     description="این متد برای به‌روزرسانی اطلاعات یک استان با شناسه مشخص استفاده می‌شود.",
     *     operationId="updateProvince",
     *     tags={"Provinces"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1),
     *         description="شناسه استان برای به‌روزرسانی"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Tehran", description="نام استان"),
     *             @OA\Property(property="ordering", type="integer", example=1, description="اولویت نمایش استان"),
     *             @OA\Property(property="is_published", type="boolean", example=true, description="وضعیت انتشار استان"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="استان با موفقیت به‌روزرسانی شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="استان با موفقیت به‌روزرسانی شد."),
     *             @OA\Property(property="province", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Tehran"),
     *                 @OA\Property(property="slug", type="string", example="tehran"),
     *                 @OA\Property(property="ordering", type="integer", example=1),
     *                 @OA\Property(property="is_published", type="boolean", example=true),
     *                 @OA\Property(property="published_at", type="string", example="2024-12-12T12:34:56"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="استان یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="استان یافت نشد.")
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
     *         description="به‌روزرسانی استان با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="به‌روزرسانی استان با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {

        try {

            if (Gate::denies('update-provinces')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }
            $slug = sluggable_helper_function($request->name);
            $data = array_merge($request->all(), ['slug' => $slug]);

            $validated = validator($data, [
                'slug' => 'sometimes|string|unique:provinces,slug,' . $id,
                'name' => 'required|string|max:255',
                'ordering' => 'nullable|integer',
                'region_id ' => 'required|exists:regions,id',
                'is_published' => 'nullable|boolean|in:0,1',
            ])->validate();

            $province = Province::findOrFail($id);

            $province->update($validated);

            return response()->json(['message' => 'استان با موفقیت به‌روزرسانی شد.', 'province' => $province]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'استان یافت نشد.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'به‌روزرسانی استان با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/provinces/{id}",
     *     summary="حذف یک استان",
     *     description="حذف یک استان بر اساس شناسه، در صورت موفقیت پیام حذف ارسال می‌شود",
     *     operationId="deleteProvince",
     *     tags={"Provinces"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="شناسه استان",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="استان با موفقیت حذف شد",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="استان با موفقیت حذف شد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="استان یافت نشد",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="استان یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="حذف استان با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            if (Gate::denies('delete-provinces')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }
            $province = Province::findOrFail($id);
            $province->delete();

            return response()->json(['message' => 'استان با موفقیت حذف شد.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'استان یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حذف استان با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/provinces/published",
     *     summary="دریافت استان‌های منتشر شده",
     *     description="دریافت لیستی از استان‌های منتشر شده همراه با پست‌ها، کمیته‌ها و کاربران مرتبط",
     *     operationId="getPublishedProvinces",
     *     tags={"Provinces"},
     *     @OA\Response(
     *         response=200,
     *         description="لیست استان‌های منتشر شده",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="slug", type="string"),
     *                 @OA\Property(property="is_published", type="boolean"),
     *                 @OA\Property(property="published_at", type="string"),
     *                 @OA\Property(property="posts", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="committees", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="users", type="array", @OA\Items(type="object"))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت استان‌های منتشرشده با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */

    public function published()
    {
        try {
            if (Gate::denies('provinces')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $provinces = Province::published()->with(['posts','committees','users'])->paginate(10);
            return response()->json($provinces);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت استان‌های منتشرشده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/provinces/draft",
     *     summary="دریافت استان‌های پیش‌نویس",
     *     description="دریافت لیستی از استان‌های پیش‌نویس همراه با پست‌ها، کمیته‌ها و کاربران مرتبط",
     *     operationId="getDraftProvinces",
     *     tags={"Provinces"},
     *     @OA\Response(
     *         response=200,
     *         description="لیست استان‌های پیش‌نویس",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="slug", type="string"),
     *                 @OA\Property(property="is_published", type="boolean"),
     *                 @OA\Property(property="published_at", type="string"),
     *                 @OA\Property(property="posts", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="committees", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="users", type="array", @OA\Items(type="object"))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت استان‌های پیش‌نویس با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function draft()
    {
        try {
            $provinces = Province::draft()->with(['posts','committees','users','members'])->paginate(10);
            return response()->json($provinces);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت استان‌های پیش‌نویس با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/province/front-all-provinces",
     *     summary="دریافت تمامی کمیته‌های منتشر شده",
     *     description="دریافت لیستی از تمامی استان‌های منتشر شده همراه با پست‌ها، کمیته‌ها و کاربران مرتبط",
     *     operationId="getAllProvinces",
     *     tags={"Provinces"},
     *     @OA\Response(
     *         response=200,
     *         description="لیست کمیته‌ها منتشر شده",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="slug", type="string"),
     *                 @OA\Property(property="is_published", type="boolean"),
     *                 @OA\Property(property="published_at", type="string"),
     *                 @OA\Property(property="posts", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="committees", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="users", type="array", @OA\Items(type="object"))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت استان‌های منتشر شده با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function frontAllProvinces(Request $request)
    {

        try {
            $query = Province::published()->with(['posts','committees','users','members']);
            $take = $request->input('take', 10);
            $provinces = $query->paginate($take);
            return response()->json($provinces);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت استان‌های منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/province/front-single-province/{slug}",
     *     summary="دریافت اطلاعات یک استان منتشر شده",
     *     description="این متد اطلاعات یک استان منتشر شده را بر اساس شناسه (slug) آن باز می‌گرداند.",
     *     operationId="getSingleProvince",
     *     tags={"Provinces"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", example="tehran"),
     *         description="شناسه (slug) استان برای دریافت اطلاعات آن"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="اطلاعات استان منتشر شده",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Tehran"),
     *             @OA\Property(property="slug", type="string", example="tehran"),
     *             @OA\Property(property="posts", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="committees", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="users", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="is_published", type="boolean", example=true),
     *             @OA\Property(property="published_at", type="string", example="2024-12-12T12:34:56")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="استان منتشر شده یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="استان منتشر شده یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت استان منتشر شده با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function frontSingleProvince(Request $request)
    {
        try {
            $province = Province::SingleProvincePublished($request->slug)->with(['posts','committees','users','members'])->first();
            return response()->json($province);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت استان‌ منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }
}
