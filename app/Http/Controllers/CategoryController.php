<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::with('posts')->paginate(10);
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت دسته‌بندی‌ها با شکست مواجه شد.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $category = Category::with('posts')->findOrFail($id);
            return response()->json($category);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'دسته‌بندی یافت نشد.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت دسته‌بندی با شکست مواجه شد.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories',
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

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255|unique:categories,name,' . $id,
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

    public function destroy($id)
    {
        try {
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
        return Str::slug($name, '-');
    }


    public function frontAllCategories()
    {
        try {
            $categories = Category::all();
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت دسته بندی ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }

    public function frontSingleCategory(Request $request)
    {
        try {
            $categories = Category::with('posts')->where('slug', $request->slug)->first();
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json(['error' => 'دریافت دسته بندی ها با شکست مواجه شد.', 'message' => $e->getMessage()], 500);
        }
    }
}
