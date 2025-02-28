<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminGoalsController extends Controller
{
    public function index()
    {
        return view('back.goals.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'goals_title' => 'required|string|max:255',
            'goals_shortContent' => 'required|string|max:1000',
        ]);
        foreach ($request->all() as $information => $value) {

            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            }

            option_update($information, $value);
        }


        toastr()->success('با موفقیت ذخیره شد');
        return redirect()->route('back.about-us.goals.index');
    }
}
