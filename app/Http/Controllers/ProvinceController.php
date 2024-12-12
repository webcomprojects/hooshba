<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProvinceController extends Controller
{

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

    public function published()
    {
        try {
            $provinces = Province::published()->with(['posts','committees','users'])->paginate(10);
            return response()->json($provinces);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت استان‌های منتشرشده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    public function draft()
    {
        try {
            $provinces = Province::draft()->with(['posts','committees','users'])->paginate(10);
            return response()->json($provinces);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت استان‌های پیش‌نویس با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }



    public function frontAllCommittees(Request $request)
    {

        try {
            $query = Province::published()->with(['posts','committees','users']);

            $provinces = $query->paginate(10);
            return response()->json($provinces);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت استان‌های منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }


    public function frontSingleCommittee(Request $request)
    {
        try {
            $province = Province::SingleProvincePublished($request->slug)->with(['posts','committees','users'])->first();
            return response()->json($province);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت استان‌ منتشر شده با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }
}
