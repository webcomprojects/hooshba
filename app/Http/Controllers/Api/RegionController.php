<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Region;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use function App\Helpers\sluggable_helper_function;

class RegionController extends Controller
{

    /**
     * @OA\Get(
     *     path="/regions",
     *     summary="دریافت لیست محله‌ها",
     *     description="این متد لیست محله‌ها را با قابلیت فیلتر بر اساس وضعیت انتشار بازمی‌گرداند.",
     *     operationId="getRegions",
     *     tags={"Regions"},
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"published"},
     *             example="published"
     *         ),
     *         description="فیلتر وضعیت انتشار محله‌ها"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="لیست محله‌ها با موفقیت دریافت شد.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"), description="لیست محله‌ها"),
     *             @OA\Property(property="links", type="object", description="لینک‌های صفحه‌بندی"),
     *             @OA\Property(property="meta", type="object", description="اطلاعات صفحه‌بندی")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="دریافت لیست محله‌ها با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت محله ها با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string", description="پیام خطا")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */

    public function index(Request $request)
    {
        /*     $user = auth()->user();
              $user->givePermissionTo('regions');
              $user->givePermissionTo('update-regions');
              $user->givePermissionTo('delete-regions');
              $user->givePermissionTo('create-regions');

              $role = Role::where('name','admin')->first(); // نقش مورد نظر
              $role->givePermissionTo('regions');
              $role->givePermissionTo('update-regions');
              $role->givePermissionTo('delete-regions');
              $role->givePermissionTo('create-regions');
              $role->givePermissionTo('show-regions');

      /*
              $user = auth()->user();
              $user->assignRole('admin');

              $user = auth()->user();
              $permissionNames = $user->getPermissionNames();
              */



        try {

            if (Gate::denies('regions')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $type = $request->query('type');
            $query = Region::with('provinces');

            if ($type === 'published') {
                $query->published();
            }

            $items = $query->paginate(10);

            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت محله ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/regions/{id}",
     *     summary="دریافت اطلاعات یک محله",
     *     description="این متد اطلاعات یک محله خاص را بر اساس شناسه بازمی‌گرداند.",
     *     operationId="getRegionById",
     *     tags={"Regions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         ),
     *         description="شناسه محله برای دریافت اطلاعات"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="اطلاعات محله با موفقیت دریافت شد.",
     *         @OA\JsonContent(
     *             type="object",
     *             description="اطلاعات محله",
     *             @OA\Property(property="id", type="integer", example=1, description="شناسه محله"),
     *             @OA\Property(property="name", type="string", example="منطقه ۱", description="نام محله"),
     *             @OA\Property(property="provinces", type="array", @OA\Items(type="object"), description="لیست استان‌های مرتبط")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="محله یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="محله ها یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="دریافت اطلاعات محله با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت محله ها با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string", description="پیام خطا")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */

    public function show($id)
    {
        try {

            if (Gate::denies('show-regions')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }


            $item = Region::with(['provinces'])->findOrFail($id);
            return response()->json($item);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'محله ها یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت محله ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/regions",
     *     summary="ایجاد محله جدید",
     *     description="این متد برای ایجاد یک محله جدید استفاده می‌شود.",
     *     operationId="createRegion",
     *     tags={"Regions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="منطقه 1", description="نام محله"),
     *             @OA\Property(property="slug", type="string", example="manategh-1", description="نامک محله (اختیاری)"),
     *             @OA\Property(property="ordering", type="integer", example=1, description="ترتیب نمایش (اختیاری)"),
     *             @OA\Property(property="is_published", type="boolean", example=true, description="وضعیت انتشار محله (اختیاری)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="محله با موفقیت ایجاد شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="محله ها با موفقیت ایجاد شد."),
     *             @OA\Property(property="province", type="object", description="اطلاعات محله ایجاد شده")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="اعتبارسنجی شکست خورد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعتبارسنجی شکست خورد."),
     *             @OA\Property(property="details", type="object", description="جزئیات خطاهای اعتبارسنجی")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="ایجاد محله با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="ایجاد محله ها با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string", description="پیام خطا")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */

    public function store(Request $request)
    {

        if ($request->has('slug')){
            $data=$request->all();
        }else{
            $slug = sluggable_helper_function($request->name);
            $data = array_merge($request->all(), ['slug' => $slug]);
        }


        try {
            if (Gate::denies('create-regions')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $validated = validator($data, [
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:regions,slug',
                'ordering' => 'nullable|integer',
                'is_published' => 'required|boolean|in:0,1',
            ])->validate();

            $validated['published_at'] = now();
            if (empty($validated['ordering'])) {
                $validated['ordering'] = Province::max('ordering') + 1;
            }
            $item = Region::create($validated);

            return response()->json(['message' => 'محله ها با موفقیت ایجاد شد.', 'province' => $item], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'ایجاد محله ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/regions/{id}",
     *     summary="ویرایش اطلاعات محله",
     *     description="این متد برای به‌روزرسانی اطلاعات یک محله مشخص استفاده می‌شود.",
     *     operationId="updateRegion",
     *     tags={"Regions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="شناسه محله برای ویرایش"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="منطقه 1 ویرایش شده", description="نام محله"),
     *             @OA\Property(property="slug", type="string", example="manategh-1-edited", description="نامک محله (اختیاری)"),
     *             @OA\Property(property="ordering", type="integer", example=2, description="ترتیب نمایش (اختیاری)"),
     *             @OA\Property(property="is_published", type="boolean", example=true, description="وضعیت انتشار محله (اختیاری)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="محله با موفقیت به‌روزرسانی شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="محله ها با موفقیت به‌روزرسانی شد."),
     *             @OA\Property(property="province", type="object", description="اطلاعات محله به‌روزرسانی شده")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="محله یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="محله ها یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="اعتبارسنجی شکست خورد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعتبارسنجی شکست خورد."),
     *             @OA\Property(property="details", type="object", description="جزئیات خطاهای اعتبارسنجی")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="به‌روزرسانی محله با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="به‌روزرسانی محله ها با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string", description="پیام خطا")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */

    public function update(Request $request, $id)
    {

        try {
            if (Gate::denies('update-regions')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            if ($request->has('slug')){
                $data=$request->all();
            }else{
                $slug = sluggable_helper_function($request->name);
                $data = array_merge($request->all(), ['slug' => $slug]);
            }

            $validated = validator($data, [
                'name' => 'required|string|max:255',
                'slug' => 'sometimes|string|unique:regions,slug,' . $id,
                'ordering' => 'nullable|integer',
                'is_published' => 'required|boolean|in:0,1',
            ])->validate();

            $item = Region::findOrFail($id);

            $item->update($validated);

            return response()->json(['message' => 'محله ها با موفقیت به‌روزرسانی شد.', 'province' => $item]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'محله ها یافت نشد.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'به‌روزرسانی محله ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/regions/{id}",
     *     summary="حذف یک محله",
     *     description="این متد برای حذف یک محله مشخص استفاده می‌شود.",
     *     operationId="deleteRegion",
     *     tags={"Regions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="شناسه محله‌ای که باید حذف شود"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="محله با موفقیت حذف شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="محله با موفقیت حذف شد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="محله یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="محله یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="حذف محله با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="حذف محله با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string", description="پیام خطا")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */

    public function destroy($id)
    {


        try {
            if (Gate::denies('delete-regions')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $item = Region::findOrFail($id);
            $item->delete();

            return response()->json(['message' => 'محله با موفقیت حذف شد.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'محله یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حذف محله با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/regions/published",
     *     summary="دریافت محله‌های منتشر شده",
     *     description="این متد لیست محله‌های منتشر شده را به همراه استان‌های مربوطه برمی‌گرداند.",
     *     operationId="getPublishedRegions",
     *     tags={"Regions"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", example=1),
     *         description="شماره صفحه برای نمایش محله‌های منتشرشده"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="لیست محله‌های منتشرشده با موفقیت دریافت شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="منطقه 1"),
     *                     @OA\Property(property="provinces", type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="id", type="integer", example=101),
     *                             @OA\Property(property="name", type="string", example="استان تهران")
     *                         )
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="total", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="دریافت محله‌های منتشرشده با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت محله‌های منتشرشده با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string", description="پیام خطا")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */

    public function published()
    {
        try {
            if (Gate::denies('regions')) {
                return response()->json(['error' => '403', 'message' => "شما مجوز دسترسی به این صفحه را ندارید."], 403);
            }

            $items = Region::published()->with(['provinces'])->paginate(10);
            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت محله‌های منتشرشده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/regions/front-all-regions",
     *     summary="دریافت تمامی محله‌های منتشر شده",
     *     description="این متد لیست تمامی محله‌های منتشر شده را به همراه استان‌های مرتبط نمایش می‌دهد.",
     *     operationId="frontAllRegions",
     *     tags={"Front Regions"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", example=1),
     *         description="شماره صفحه برای نمایش محله‌های منتشرشده"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="لیست محله‌های منتشرشده با موفقیت دریافت شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="منطقه 1"),
     *                     @OA\Property(property="provinces", type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="id", type="integer", example=101),
     *                             @OA\Property(property="name", type="string", example="استان تهران")
     *                         )
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="total", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="دریافت محله‌های منتشرشده با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت محله‌های منتشرشده با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string", description="پیام خطا")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */

    public function frontAllRegions(Request $request)
    {

        try {
            $query = Region::published()->with(['provinces']);
            $take = $request->input('take', 10);
            $items = $query->paginate($take);
            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت محله‌های منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/regions/front-single-region",
     *     summary="دریافت اطلاعات یک محله منتشر شده",
     *     description="این متد جزئیات مربوط به یک محله منتشر شده را به همراه استان‌های مرتبط نمایش می‌دهد.",
     *     operationId="frontSingleRegion",
     *     tags={"Front Regions"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="اسلاگ محله‌ای که باید دریافت شود"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="اطلاعات محله با موفقیت دریافت شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="منطقه 1"),
     *             @OA\Property(property="provinces", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=101),
     *                     @OA\Property(property="name", type="string", example="استان تهران")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="دریافت محله منتشر شده با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت محله منتشر شده با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string", description="پیام خطا")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */

    public function frontSingleRegion(Request $request)
    {
        try {
            $item = Region::SingleRegionPublished($request->slug)->with(['provinces'])->first();
            return response()->json($item);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت محله منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }
}
