<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->published()->first();

        if (!$page) {
            throw new ModelNotFoundException('صفحه مورد نظر یافت نشد.');
        }

        return view('front.pages.show', compact('page'));
    }
}