<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CommitteeController extends Controller
{

    /**
     * @OA\Get(
     *     path="/committees",
     *     summary="Get all committees",
     *     description="این متد تمامی کمیته‌ها را بازمی‌گرداند.",
     *     operationId="getCommittees",
     *     tags={"Committees"},
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
     *         description="نوع کمیته‌ها (منتشر شده یا پیش‌نویس)"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="لیست کمیته‌ها.",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="pagination", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت کمیته‌ها با شکست مواجه شد.")
     *         )
     *     )
     * )
     */

    public function index(Request $request)
    {
        try {
            $type = $request->query('type');
            $query = Committee::with(['user', 'province']);

            if ($type === 'published') {
                $query->published();
            } elseif ($type === 'draft') {
                $query->draft();
            }

            $committees = $query->paginate(10);

            return response()->json($committees);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت کمیته‌ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/committees/{id}",
     *     summary="Get a specific committee",
     *     description="این متد یک کمیته مشخص را بازمی‌گرداند.",
     *     operationId="getCommittee",
     *     tags={"Committees"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         ),
     *         description="شناسه کمیته"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="اطلاعات کمیته.",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="کمیته یافت نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="کمیته یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطای داخلی سرور.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت کمیته با شکست مواجه شد.")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $committee = Committee::with(['user', 'province'])->findOrFail($id);
            return response()->json($committee);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'کمیته یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت کمیته با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/committees",
     *     summary="Create a new committee",
     *     description="این متد یک کمیته جدید ایجاد می‌کند.",
     *     operationId="createCommittee",
     *     tags={"Committees"},
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
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Committee Name"),
     *             @OA\Property(property="phone", type="string", example="09123456789"),
     *             @OA\Property(property="members", type="string", example="John, Doe, Jane"),
     *             @OA\Property(property="email", type="string", example="committee@example.com"),
     *             @OA\Property(property="content", type="string", example="Description of the committee"),
     *             @OA\Property(property="slug", type="string", example="committee-name"),
     *             @OA\Property(property="image", type="string", format="binary"),
     *             @OA\Property(property="is_published", type="boolean", example=true),
     *             @OA\Property(property="province_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="کمیته با موفقیت ایجاد شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="کمیته با موفقیت ایجاد شد."),
     *             @OA\Property(property="committee", type="object")
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
     *         description="ایجاد کمیته با شکست مواجه شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="ایجاد کمیته با شکست مواجه شد."),
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
                'name' => 'required|string|max:255',
                'phone' => 'nullable|digits:11|regex:/(09)[0-9]{9}/',
                'members' => 'nullable|string',
                'email' => 'nullable|email|max:255',
                'content' => 'nullable|string',
                'slug' => 'nullable|string|unique:committees,slug',
                'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'is_published' => 'boolean',
                'province_id' => 'nullable|exists:provinces,id'
            ])->validate();

            $validated['published_at'] = now();
            $validated['user_id'] = $request->user()->id;

            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request);
                $validated['image'] = $imagePath;
            }

            $committee = Committee::create($validated);

           /* if (!empty($validated['categories'])) {
                $committee->categories()->sync($validated['categories']);
            }*/

            return response()->json(['message' => 'کمیته با موفقیت ایجاد شد.', 'committee' => $committee], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'ایجاد کمیته با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Put(
     *     path="/committees/{id}",
     *     summary="Update an existing committee",
     *     description="Update the details of an existing committee by its ID",
     *     operationId="updateCommittee",
     *     tags={"Committees"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the committee to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", maxLength=255),
     *             @OA\Property(property="phone", type="string", pattern="^(09)[0-9]{9}$", nullable=true),
     *             @OA\Property(property="members", type="string", nullable=true),
     *             @OA\Property(property="email", type="string", format="email", maxLength=255, nullable=true),
     *             @OA\Property(property="content", type="string", nullable=true),
     *             @OA\Property(property="slug", type="string", nullable=true),
     *             @OA\Property(property="image", type="string", format="binary", nullable=true),
     *             @OA\Property(property="is_published", type="boolean", nullable=true),
     *             @OA\Property(property="province_id", type="integer", nullable=true),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Committee updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="کمیته با موفقیت به‌روزرسانی شد."),
     *             @OA\Property(
     *                 property="committee",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="phone", type="string", nullable=true),
     *                 @OA\Property(property="members", type="string", nullable=true),
     *                 @OA\Property(property="email", type="string", nullable=true),
     *                 @OA\Property(property="content", type="string", nullable=true),
     *                 @OA\Property(property="slug", type="string", nullable=true),
     *                 @OA\Property(property="image", type="string", nullable=true),
     *                 @OA\Property(property="is_published", type="boolean", nullable=true),
     *                 @OA\Property(property="province_id", type="integer", nullable=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Committee not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="کمیته یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="اعتبارسنجی شکست خورد."),
     *             @OA\Property(property="details", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="به‌روزرسانی کمیته با شکست مواجه شد."),
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
                'name' => 'required|string|max:255',
                'phone' => 'nullable|digits:11|regex:/(09)[0-9]{9}/',
                'members' => 'nullable|string',
                'email' => 'nullable|email|max:255',
                'content' => 'nullable|string',
                'slug' => 'sometimes|string|unique:committees,slug,' . $id,
                'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'is_published' => 'boolean',
                'province_id' => 'nullable|exists:provinces,id'
            ])->validate();

            $committee = Committee::findOrFail($id);

            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request);
                $validated['image'] = $imagePath;
            }

            $committee->update($validated);

          /*  if (isset($validated['categories'])) {
                $committee->categories()->sync($validated['categories']);
            }*/

            return response()->json(['message' => 'کمیته با موفقیت به‌روزرسانی شد.', 'committee' => $committee]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'کمیته یافت نشد.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'اعتبارسنجی شکست خورد.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'به‌روزرسانی کمیته با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Delete(
     *     path="/committees/{id}",
     *     summary="Delete a committee",
     *     description="Delete an existing committee by its ID",
     *     operationId="deleteCommittee",
     *     tags={"Committees"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the committee to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Committee deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="کمیته با موفقیت حذف شد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Committee not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="کمیته یافت نشد.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="حذف کمیته با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        try {
            $committee = Committee::findOrFail($id);
            $committee->delete();

            return response()->json(['message' => 'کمیته با موفقیت حذف شد.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'کمیته یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حذف کمیته با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/committees/published",
     *     summary="Get published committees",
     *     description="Fetch a list of published committees with user and province information",
     *     operationId="getPublishedCommittees",
     *     tags={"Committees"},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved the list of published committees",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="phone", type="string", nullable=true),
     *                     @OA\Property(property="email", type="string", nullable=true),
     *                     @OA\Property(property="is_published", type="boolean"),
     *                     @OA\Property(property="user", type="object",
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string")
     *                     ),
     *                     @OA\Property(property="province", type="object",
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string")
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت کمیته‌های منتشرشده با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function published()
    {
        try {
            $committees = Committee::published()->with(['user', 'province'])->paginate(10);
            return response()->json($committees);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت کمیته‌های منتشرشده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/committees/draft",
     *     summary="Get draft committees",
     *     description="Fetch a list of draft committees with user and province information",
     *     operationId="getDraftCommittees",
     *     tags={"Committees"},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved the list of draft committees",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="phone", type="string", nullable=true),
     *                     @OA\Property(property="email", type="string", nullable=true),
     *                     @OA\Property(property="is_published", type="boolean"),
     *                     @OA\Property(property="user", type="object",
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string")
     *                     ),
     *                     @OA\Property(property="province", type="object",
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string")
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت کمیته‌های پیش‌نویس با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */

    public function draft()
    {
        try {
            $committees = Committee::draft()->with(['user', 'province'])->paginate(10);
            return response()->json($committees);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت کمیته‌های پیش‌نویس با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    private function uploadImage(Request $request, $inputName = 'image')
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
     *     path="/committees/front-all-committees",
     *     summary="Get all published committees",
     *     description="Fetch a list of all published committees, optionally filtered by province",
     *     operationId="getFrontAllCommittees",
     *     tags={"Committees"},
     *     @OA\Parameter(
     *         name="province",
     *         in="query",
     *         description="Filter committees by province",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved the list of published committees",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="phone", type="string", nullable=true),
     *                     @OA\Property(property="email", type="string", nullable=true),
     *                     @OA\Property(property="is_published", type="boolean"),
     *                     @OA\Property(property="user", type="object",
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string")
     *                     ),
     *                     @OA\Property(property="province", type="object",
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string")
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت کمیته‌های منتشر شده با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */

    public function frontAllCommittees(Request $request)
    {

        try {
            $query = Committee::published()->with(['province','user']);
            if ($request->filled('province')) {
                $query->where('province_id', $request->province);
            }
            $committees = $query->paginate(10);
            return response()->json($committees);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت کمیته‌های منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/front-single-committee/{slug}",
     *     summary="Get a single published committee",
     *     description="Fetch a single published committee by its slug",
     *     operationId="getFrontSingleCommittee",
     *     tags={"Committees"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug of the committee to retrieve",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved the single published committee",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="phone", type="string", nullable=true),
     *             @OA\Property(property="email", type="string", nullable=true),
     *             @OA\Property(property="is_published", type="boolean"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string")
     *             ),
     *             @OA\Property(property="province", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="دریافت کمیته منتشر شده با شکست مواجه شد."),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */

    public function frontSingleCommittee(Request $request)
    {
        try {
            $committee = Committee::SingleCommitteePublished($request->slug)->with(['province','user'])->first();
            return response()->json($committee);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت کمیته‌ منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }
}
