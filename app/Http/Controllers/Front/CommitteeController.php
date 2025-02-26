<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Committee;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('c'); // فیلتر دسته‌بندی
        $keyword = $request->query('k'); // فیلتر کلمه کلیدی

        $query = Committee::with(['categories'])->published();

        // فیلتر بر اساس دسته‌بندی
        if ($categorySlug) {
            $query->whereHas('categories', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // فیلتر بر اساس کلمه کلیدی
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('content', 'LIKE', "%{$keyword}%");
            });
        }


        $committees = $query->orderBy('created_at', 'desc')->paginate(20);
        //$last_posts = Committee::with('categories')->orderBy('created_at', 'desc')->take(4)->get();
        $categories = Category::get();

        return view('front.committees.index', compact('committees', 'categories'));
    }


    public function show(Committee $committee)
    {
        return view('front.committees.show', compact('committee'));
    }
}
