<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPlansController extends Controller
{
    public function index()
    {
        return view('back.plans.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plans_title' => 'required|string|max:255',
            'plans_shortContent' => 'required|string|max:1000',
        ]);
        foreach ($request->all() as $information => $value) {

            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            }

            option_update($information, $value);
        }


        toastr()->success('با موفقیت ذخیره شد');
        return redirect()->route('back.about-us.plans.index');
    }
}
