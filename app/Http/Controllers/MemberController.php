<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Province;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    /**
     * @OA\Get(
     *     path="/members",
     *     summary="دریافت لیست اعضا",
     *     description="این متد لیستی از اعضا را با امکان فیلتر کردن بر اساس نوع برمی‌گرداند.",
     *     operationId="getMembers",
     *     tags={"Members"},
     *          @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *          ),
     *          description="توکن احراز هویت به صورت Bearer Token"
     *      ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="student"
     *         ),
     *         description="نوع اعضا برای فیلتر کردن (مثلاً: student یا teacher)"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="لیست اعضا با موفقیت بازیابی شد.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="دریافت اعضا با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت اعضا با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */

    public function index(Request $request)
    {
        try {

            $query = Member::query();

            if ($request->has('type')){
                $query->where('type',$request->type);
            }


            $provinces = $query->paginate(10);

            return response()->json($provinces);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت اعضا با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/members/{id}",
     *     summary="دریافت اطلاعات یک عضو خاص",
     *     description="این متد اطلاعات مربوط به یک عضو خاص را بر اساس شناسه برمی‌گرداند.",
     *     operationId="getMemberById",
     *     tags={"Members"},
     *          @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *          ),
     *          description="توکن احراز هویت به صورت Bearer Token"
     *      ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         ),
     *         description="شناسه عضو"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="عضو با موفقیت پیدا شد.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="type", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="عضو یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعضا یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="دریافت اطلاعات عضو با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعضا با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $item = Member::findOrFail($id);
            return response()->json($item);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'اعضا یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'اعضا با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/members",
     *     summary="ایجاد عضو جدید",
     *     description="این متد برای ایجاد یک عضو جدید در سیستم استفاده می‌شود.",
     *     operationId="storeMember",
     *     tags={"Members"},
     *          @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *          ),
     *          description="توکن احراز هویت به صورت Bearer Token"
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe", description="نام عضو"),
     *             @OA\Property(property="type", type="string", example="council", enum={"council", "presidency"}, description="نوع عضو"),
     *             @OA\Property(property="job_position", type="array", @OA\Items(type="string"), example={"Manager", "Developer"}, description="موقعیت شغلی عضو"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com", description="ایمیل عضو"),
     *             @OA\Property(property="mobile", type="string", example="09123456789", description="شماره تلفن همراه عضو"),
     *             @OA\Property(property="links", type="array", @OA\Items(type="string"), example={"https://linkedin.com/johndoe"}, description="لینک‌های مرتبط با عضو"),
     *             @OA\Property(property="description", type="string", example="توضیحات در مورد عضو", description="توضیحات"),
     *             @OA\Property(property="image", type="string", format="binary", description="تصویر عضو"),
     *             @OA\Property(property="educational_background", type="array", @OA\Items(type="string"), example={"Bachelor in CS", "Master in IT"}, description="سوابق تحصیلی"),
     *             @OA\Property(property="executive_background", type="array", @OA\Items(type="string"), example={"5 years at XYZ", "3 years at ABC"}, description="سوابق اجرایی"),
     *             @OA\Property(property="is_published", type="boolean", example=true, description="وضعیت انتشار"),
     *             @OA\Property(property="categories", type="array", @OA\Items(type="integer"), example={1, 2, 3}, description="شناسه دسته‌بندی‌ها")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="عضو با موفقیت ایجاد شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="اعضا با موفقیت ایجاد شد."),
     *             @OA\Property(property="province", type="object", description="اطلاعات عضو ایجاد شده")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="اعتبارسنجی شکست خورد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعتبارسنجی شکست خورد."),
     *             @OA\Property(property="details", type="object", description="جزئیات خطا")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="ایجاد عضو با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="ایجاد عضو با شکست مواجه شد."),
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
        $slug = Str::slug($request->name, '-');
        $data = array_merge($request->all(), ['slug' => $slug]);

        try {
            $validated = validator($data, [
                'slug' => 'nullable|string|unique:members,slug',
                'type' => 'required|in:council,presidency',
                'name' => 'required|string|max:255',
                'job_position' => 'nullable|array',
                'email' => 'nullable|string|max:255|email',
                'mobile' => 'nullable|digits:11|regex:/^[0][9][0-9]{9,9}$/',
                'links' => 'nullable|array',
                'description' => 'nullable|string',
                'image' => 'nullable',
                'educational_background' => 'nullable|array',
                'executive_background' => 'nullable|array',
                'is_published' => 'boolean',
            ])->validate();

            $validated['published_at'] = now();

            $validated['user_id'] = $request->user()->id;

            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request);
                $validated['image'] = $imagePath;
            }

            $validated['links'] = json_encode($request->links);
            $validated['job_position'] = json_encode($request->job_position);
            $validated['educational_background'] = json_encode($request->educational_background);
            $validated['executive_background'] = json_encode($request->executive_background);



            $item = Member::create($validated);

            if (!empty($validated['categories'])) {
                $item->categories()->sync($validated['categories']);
            }

            return response()->json(['message' => 'اعضا با موفقیت ایجاد شد.', 'province' => $item], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'ایجاد اعضا با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Put(
     *     path="/members/{id}",
     *     summary="به‌روزرسانی اطلاعات عضو",
     *     description="این متد اطلاعات یک عضو موجود را به‌روزرسانی می‌کند.",
     *     operationId="updateMember",
     *     tags={"Members"},
     *          @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *          ),
     *          description="توکن احراز هویت به صورت Bearer Token"
     *      ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         ),
     *         description="شناسه عضو برای به‌روزرسانی"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe", description="نام عضو"),
     *             @OA\Property(property="type", type="string", example="council", enum={"council", "presidency"}, description="نوع عضو"),
     *             @OA\Property(property="categories", type="array", @OA\Items(type="integer"), example={1, 2, 3}, description="شناسه دسته‌بندی‌ها"),
     *             @OA\Property(property="job_position", type="array", @OA\Items(type="string"), example={"Manager", "Developer"}, description="موقعیت شغلی عضو"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com", description="ایمیل عضو"),
     *             @OA\Property(property="mobile", type="string", example="09123456789", description="شماره تلفن همراه عضو"),
     *             @OA\Property(property="links", type="array", @OA\Items(type="string"), example={"https://linkedin.com/johndoe"}, description="لینک‌های مرتبط با عضو"),
     *             @OA\Property(property="description", type="string", example="توضیحات در مورد عضو", description="توضیحات"),
     *             @OA\Property(property="image", type="string", format="binary", description="تصویر عضو"),
     *             @OA\Property(property="educational_background", type="array", @OA\Items(type="string"), example={"Bachelor in CS", "Master in IT"}, description="سوابق تحصیلی"),
     *             @OA\Property(property="executive_background", type="array", @OA\Items(type="string"), example={"5 years at XYZ", "3 years at ABC"}, description="سوابق اجرایی"),
     *             @OA\Property(property="is_published", type="boolean", example=true, description="وضعیت انتشار")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="عضو با موفقیت به‌روزرسانی شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="اعضا با موفقیت به‌روزرسانی شد."),
     *             @OA\Property(property="Member", type="object", description="اطلاعات عضو به‌روزرسانی شده")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="عضو یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعضا یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="اعتبارسنجی شکست خورد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعتبارسنجی شکست خورد."),
     *             @OA\Property(property="details", type="object", description="جزئیات خطا")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="به‌روزرسانی عضو با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="به‌روزرسانی عضو با شکست مواجه شد."),
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
        $slug = Str::slug($request->name, '-');
        $data = array_merge($request->all(), ['slug' => $slug]);


        try {
            $validated = validator($data, [
                'slug' => 'sometimes|string|unique:members,slug,' . $id,
                'type' => 'required|in:council,presidency',
                'categories' => 'nullable|array',
                'categories.*' => 'exists:categories,id',
                'name' => 'required|string|max:255',
                'job_position' => 'nullable|array',
                'email' => 'nullable|string|max:255|email',
                'mobile' => 'nullable|digits:11|regex:/^[0][9][0-9]{9,9}$/',
                'links' => 'nullable|array',
                'description' => 'nullable|string',
                'image' => 'nullable',
                'educational_background' => 'nullable|array',
                'executive_background' => 'nullable|array',
                'is_published' => 'boolean',
            ])->validate();

            $item = Member::findOrFail($id);

            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request);
                $validated['image'] = $imagePath;
            }

            $validated['links'] = json_encode($request->links);
            $validated['job_position'] = json_encode($request->job_position);
            $validated['executive_background'] = json_encode($request->executive_background);
            $validated['executive_background'] = json_encode($request->executive_background);


            $item->update($validated);

            if (isset($validated['categories'])) {
                $item->categories()->sync($validated['categories']);
            }



            return response()->json(['message' => 'اعضا با موفقیت به‌روزرسانی شد.', 'province' => $item]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'اعضا یافت نشد.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'به‌روزرسانی اعضا با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/members/{id}",
     *     summary="حذف عضو",
     *     description="این متد یک عضو مشخص را حذف می‌کند.",
     *     operationId="deleteMember",
     *     tags={"Members"},
     *          @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
     *          ),
     *          description="توکن احراز هویت به صورت Bearer Token"
     *      ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         ),
     *         description="شناسه عضو برای حذف"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="عضو با موفقیت حذف شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="اعضا با موفقیت حذف شد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="عضو یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعضا یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="حذف عضو با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="حذف اعضا با شکست مواجه شد."),
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
            $province = Member::findOrFail($id);
            $province->delete();

            return response()->json(['message' => 'اعضا با موفقیت حذف شد.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'اعضا یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حذف اعضا با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/members/published",
     *     summary="دریافت اعضا منتشرشده",
     *     description="این متد اعضا منتشرشده را به صورت صفحه‌بندی‌شده باز می‌گرداند.",
     *     operationId="getPublishedMembers",
     *     tags={"Members"},
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
     *         description="لیست اعضا منتشرشده با موفقیت دریافت شد.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"), description="لیست اعضا"),
     *             @OA\Property(property="links", type="object", description="لینک‌های صفحه‌بندی"),
     *             @OA\Property(property="meta", type="object", description="اطلاعات صفحه‌بندی")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="دریافت اعضا منتشرشده با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت اعضا منتشرشده با شکست مواجه شد."),
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
            $items = Member::published()->paginate(10);
            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت اعضا منتشرشده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/members/front/all",
     *     summary="دریافت لیست اعضا منتشرشده",
     *     description="این متد لیست اعضا منتشرشده را با قابلیت فیلتر نوع بازمی‌گرداند.",
     *     operationId="getFrontAllMembers",
     *     tags={"Members"},
     *          @OA\Parameter(
     *          name="type",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"published", "draft"},
     *              example="published"
     *          ),
     *          description="نوع پست‌ها (منتشر شده یا پیش‌نویس)"
     *      ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"council", "presidency"},
     *             example="council"
     *         ),
     *         description="نوع عضو برای فیلتر کردن لیست"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="لیست اعضا منتشرشده با موفقیت دریافت شد.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"), description="لیست اعضا"),
     *             @OA\Property(property="links", type="object", description="لینک‌های صفحه‌بندی"),
     *             @OA\Property(property="meta", type="object", description="اطلاعات صفحه‌بندی")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="دریافت لیست اعضا منتشرشده با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت اعضاهای منتشر شده با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string", description="پیام خطا")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function frontAllMembers(Request $request)
    {
        try {
            $query = Member::published();

            if ($request->has('type')){
                $query->where('type',$request->type);
            }
            $items = $query->paginate(10);
            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت اعضاهای منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/members/front/{slug}",
     *     summary="دریافت اطلاعات یک عضو منتشرشده",
     *     description="این متد اطلاعات یک عضو منتشرشده را بر اساس اسلاگ بازمی‌گرداند.",
     *     operationId="getFrontSingleMember",
     *     tags={"Members"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="john-doe"
     *         ),
     *         description="اسلاگ عضو برای دریافت اطلاعات"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="اطلاعات عضو با موفقیت دریافت شد.",
     *         @OA\JsonContent(
     *             type="object",
     *             description="اطلاعات عضو",
     *             @OA\Property(property="id", type="integer", example=1, description="شناسه عضو"),
     *             @OA\Property(property="name", type="string", example="John Doe", description="نام عضو"),
     *             @OA\Property(property="type", type="string", example="council", description="نوع عضو"),
     *             @OA\Property(property="description", type="string", example="توضیحات درباره عضو", description="توضیحات"),
     *             @OA\Property(property="image", type="string", example="image.jpg", description="تصویر عضو"),
     *             @OA\Property(property="links", type="array", @OA\Items(type="string"), description="لینک‌های مرتبط با عضو")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="دریافت اطلاعات عضو با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت اعضا‌ منتشر شده با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string", description="پیام خطا")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function frontSingleMember(Request $request)
    {
        try {
            $item = Member::SingleMemberPublished($request->slug)->first();
            return response()->json($item);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت اعضا‌ منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }
}
