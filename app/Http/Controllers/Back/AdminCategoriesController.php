<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoriesController extends Controller
{

    public function store(Request $request)
    {
        $slug = sluggable_helper_function($request->name);
        $request->merge(['slug' => $slug]);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:categories,slug',
            'type' => 'required|in:post,committee,member',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'type' => $request->type,
        ]);

        toastr()->success('دسته بندی با موفیت اضافه شد');

        if ($request->type == "post") {
            return redirect()->route('back.posts.categories');
        }elseif ($request->type == "member") {
            return redirect()->route('back.members.categories');
        }elseif ($request->type == "committee") {
            return redirect()->route('back.committees.categories');
        }else{
            return redirect()->route('back.dashboard');
        }
    }

    public function updateOrdering(Request $request)
    {
        $categories = json_decode($request->input('categories'), true); // دیکد کردن JSON

        if (!$categories) {
            return response()->json(['error' => 'داده‌ای ارسال نشده است!'], 400);
        }
        $this->updateCategoryOrder($categories, null, 0);

        return response()->json(['message' => 'دسته‌بندی‌ها با موفقیت به‌روز شدند.']);
    }

    private function updateCategoryOrder($categories, $parentId = null, $order = 0)
    {
        foreach ($categories as $index => $category) {
            Category::where('id', $category['id'])->update([
                'parent_id' => $parentId,
                'ordering' => $index + $order // ترتیب را بر اساس موقعیت جدید تنظیم می‌کنیم
            ]);

            if (!empty($category['children'])) {
                $this->updateCategoryOrder($category['children'], $category['id'], 0);
            }
        }
    }
}
