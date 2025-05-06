<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class AdminMenusController extends Controller
{

    public function index(){
        $cats = Menu::orderBy('ordering', 'asc')->get()->toArray();
        $menus = categoriesBuildTree($cats);
        return view("back.menus.index",compact("menus"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'class_name' => 'nullable|string|max:255',
        ]);
        $maxOrdering = Menu::max('ordering');
        Menu::create([
            'name' => $request->name,
            'class_name' => $request->class_name,
            'ordering' => $maxOrdering + 1
        ]);

        return redirect()->route('back.settings.menus.index');
    }

    public function updateOrdering(Request $request)
    {
        $menus = json_decode($request->input('menus'), true); // دیکد کردن JSON

        if (!$menus) {
            return response()->json(['error' => 'داده‌ای ارسال نشده است!'], 400);
        }
        $this->updateMenuOrder($menus, null, 0);

        return response()->json(['message' => 'منوها با موفقیت به‌روز شدند.']);
    }

    private function updateMenuOrder($menus, $parentId = null, $order = 0)
    {
        foreach ($menus as $index => $menu) {
            // Update the current menu item
            Menu::where('id', $menu['id'])->update([
                'parent_id' => $parentId,
                'ordering' => $order + $index
            ]);

            // If there are children, update them with the correct parent ID
            if (isset($menu['children']) && is_array($menu['children'])) {
                $this->updateMenuOrder($menu['children'], $menu['id'], 0);
            }
        }
    }

    public function edit(Menu $menu)
    {
        return $menu;
    }

    public function update(Request $request,Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'class_name' => 'nullable|string|max:255',
        ]);

        $menu->update([
            'name' => $request->name,
            'link' => $request->link,
            'class_name' => $request->class_name,
        ]);

        return redirect()->back();
    }

    public function destroy(Menu $menu)
    {
        $this->authorize('posts.delete');


        $this->deleteChildren($menu);
        // حذف پست
        $menu->delete();
        //toastr()->success('دسته بندی با موفقیت حذف شد');

        return redirect()->back();
    }


    private function deleteChildren(Menu $menu)
    {
        foreach ($menu->children as $child) {
            $this->deleteChildren($child); // حذف فرزندان به‌صورت بازگشتی
            $child->delete(); // حذف دسته‌بندی فرزند
        }
    }
}
