<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
            $type = $request->query('type');
            $query = Province::with(['posts','committees','users']);

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
            $province = Province::with(['posts','committees','users'])->findOrFail($id);
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
     *     description="ایجاد یک استان جدید با اعتبارسنجی برای نام، اسلاگ، ترتیب و وضعیت انتشار",
     *     operationId="createProvince",
     *     tags={"Provinces"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\Content(
     *             mediaType="application/json",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="نام استان",
     *                 example="Tehran"
     *             ),
     *             @OA\Property(
     *                 property="slug",
     *                 type="string",
     *                 description="اسلاگ استان (اختیاری)",
     *                 example="tehran"
     *             ),
     *             @OA\Property(
     *                 property="ordering",
     *                 type="integer",
     *                 description="ترتیب استان (اختیاری)",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="is_published",
     *                 type="boolean",
     *                 description="وضعیت انتشار استان",
     *                 example=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="استان با موفقیت ایجاد شد",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="استان با موفقیت ایجاد شد."),
     *             @OA\Property(property="province", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="slug", type="string"),
     *                 @OA\Property(property="ordering", type="integer"),
     *                 @OA\Property(property="is_published", type="boolean"),
     *                 @OA\Property(property="published_at", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="اعتبارسنجی شکست خورد",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعتبارسنجی شکست خورد."),
     *             @OA\Property(property="details", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="ایجاد استان با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $slug = Str::slug($request->name, '-');
        $data = array_merge($request->all(), ['slug' => $slug]);

        try {
            $validated = validator($data, [
                'slug' => 'nullable|string|unique:provinces,slug',
                'name' => 'required|string|max:255',
                'ordering' => 'nullable|integer',
                'is_published' => 'boolean',
            ])->validate();

            $validated['published_at'] = now();
            if (empty($validated['ordering'])) {
                $validated['ordering'] = Province::max('ordering') + 1; // گرفتن بیشترین مقدار ordering و افزودن 1
            }
            $province = Province::create($validated);

            /* if (!empty($validated['categories'])) {
                 $province->categories()->sync($validated['categories']);
             }*/

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
     *     summary="به‌روزرسانی یک استان",
     *     description="به‌روزرسانی اطلاعات یک استان با اعتبارسنجی برای نام، اسلاگ، ترتیب و وضعیت انتشار",
     *     operationId="updateProvince",
     *     tags={"Provinces"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="شناسه استان",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\Content(
     *             mediaType="application/json",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="نام استان",
     *                 example="Tehran"
     *             ),
     *             @OA\Property(
     *                 property="slug",
     *                 type="string",
     *                 description="اسلاگ استان (اختیاری)",
     *                 example="tehran"
     *             ),
     *             @OA\Property(
     *                 property="ordering",
     *                 type="integer",
     *                 description="ترتیب استان (اختیاری)",
     *                 example=2
     *             ),
     *             @OA\Property(
     *                 property="is_published",
     *                 type="boolean",
     *                 description="وضعیت انتشار استان",
     *                 example=false
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="استان با موفقیت به‌روزرسانی شد",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="استان با موفقیت به‌روزرسانی شد."),
     *             @OA\Property(property="province", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="slug", type="string"),
     *                 @OA\Property(property="ordering", type="integer"),
     *                 @OA\Property(property="is_published", type="boolean"),
     *                 @OA\Property(property="published_at", type="string")
     *             )
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
     *         response=422,
     *         description="اعتبارسنجی شکست خورد",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعتبارسنجی شکست خورد."),
     *             @OA\Property(property="details", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="به‌روزرسانی استان با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $slug = Str::slug($request->name, '-');
        $data = array_merge($request->all(), ['slug' => $slug]);

        try {
            $validated = validator($data, [
                'slug' => 'sometimes|string|unique:provinces,slug,' . $id,
                'name' => 'required|string|max:255',
                'ordering' => 'nullable|integer',
                'is_published' => 'boolean',
            ])->validate();

            $province = Province::findOrFail($id);

            $province->update($validated);

            /*  if (isset($validated['categories'])) {
                  $province->categories()->sync($validated['categories']);
              }*/

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
            $provinces = Province::draft()->with(['posts','committees','users'])->paginate(10);
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
            $query = Province::published()->with(['posts','committees','users']);

            $provinces = $query->paginate(10);
            return response()->json($provinces);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت استان‌های منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/province/front-single-province/{slug}",
     *     summary="دریافت کمیته منتشر شده با شناسه خاص",
     *     description="دریافت اطلاعات یک استان منتشر شده با استفاده از شناسه (slug)، همراه با پست‌ها، کمیته‌ها و کاربران مرتبط",
     *     operationId="getSingleProvince",
     *     tags={"provinces"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="شناسه استان (slug)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="اطلاعات کمیته منتشر شده",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="slug", type="string"),
     *             @OA\Property(property="is_published", type="boolean"),
     *             @OA\Property(property="published_at", type="string"),
     *             @OA\Property(property="posts", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="committees", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="users", type="array", @OA\Items(type="object"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور",
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
            $province = Province::SingleProvincePublished($request->slug)->with(['posts','committees','users'])->first();
            return response()->json($province);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت استان‌ منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }
}
