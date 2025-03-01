<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\OrganizationChart;
use Illuminate\Http\Request;

class AdminOrganizationChartController extends Controller
{
    public function index()
    {
        $charts=OrganizationChart::orderBy('ordering','asc')->get()->toArray();
        $organization_charts=categoriesBuildTree($charts);

        return view('back.organization-chart.index',compact('organization_charts'));
    }

    public function store(Request $request)
    {
        $slug = sluggable_helper_function($request->name);
        $request->merge(['slug' => $slug]);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:organization_charts,slug',
            'description' => 'nullable|string|max:1000',
        ]);
        $maxOrdering = OrganizationChart::max('ordering');
        OrganizationChart::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'ordering' => $maxOrdering + 1
        ]);

       // toastr()->success('دسته بندی با موفیت اضافه شد');


        return redirect()->route('back.organization-chart.index');

    }

    public function updateOrdering(Request $request)
    {
        $organizationCharts = json_decode($request->input('organizationCharts'), true); // دیکد کردن JSON

        if (!$organizationCharts) {
            return response()->json(['error' => 'داده‌ای ارسال نشده است!'], 400);
        }
        $this->updateOrganizationChartOrder($organizationCharts, null, 0);

        return response()->json(['message' => 'چارت ها با موفقیت به‌روز شدند.']);
    }

    private function updateOrganizationChartOrder($organizationCharts, $parentId = null, $order = 0)
    {
        foreach ($organizationCharts as $index => $organizationChart) {
            OrganizationChart::where('id', $organizationChart['id'])->update([
                'parent_id' => $parentId,
                'ordering' => $index + $order // ترتیب را بر اساس موقعیت جدید تنظیم می‌کنیم
            ]);

            if (!empty($organizationChart['children'])) {
                $this->updateOrganizationChartOrder($organizationChart['children'], $organizationChart['id'], 0);
            }
        }
    }

    public function edit(OrganizationChart $organizationChart)
    {
        return $organizationChart;
    }

    public function update(Request $request,OrganizationChart $organizationChart)
    {
        $slug = sluggable_helper_function($request->name);
        $request->merge(['slug' => $slug]);
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:organization_charts,slug,'.$organizationChart->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $organizationChart->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
        ]);
       // toastr()->success('دسته بندی با موفیت ویرایش شد');

        return redirect()->back();

    }

    public function destroy(OrganizationChart $organizationChart)
    {
        $this->authorize('posts.delete');


        $this->deleteChildren($organizationChart);
        // حذف پست
        $organizationChart->delete();
        //toastr()->success('دسته بندی با موفقیت حذف شد');

        return redirect()->back();
    }


    private function deleteChildren(OrganizationChart $organizationChart)
    {
        foreach ($organizationChart->children as $child) {
            $this->deleteChildren($child); // حذف فرزندان به‌صورت بازگشتی
            $child->delete(); // حذف دسته‌بندی فرزند
        }
    }
}
