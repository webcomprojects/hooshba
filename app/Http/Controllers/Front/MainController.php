<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index()
    {
        $last_posts = Post::with('categories')->whereNull('video')->orWhere('video', 'null')->orderBy('created_at', 'desc')->published()->take(3)->get();
        $posts = Post::orderBy('created_at', 'desc')->published()->take(4)->get();

        $event_posts = Post::with('categories')->whereHas('categories', function ($query) {
            $query->where('slug', 'رویداد');
        })->orderBy('created_at', 'desc')->take(10)->get();


        $video_posts = Post::with('categories')->whereHas('categories', function ($query) {
            $query->where('slug', 'ویدئو');
        })->orderBy('created_at', 'desc')->published()->take(4)->get();

        return view('front.index', compact('last_posts', 'video_posts','event_posts', 'posts'));
    }

    public function captcha()
    {
        return response(['captcha' => captcha_src('flat')]);
    }

    public function get_tags(Request $request)
    {
        $tags = Tag::detectLang()->where('name', 'like', '%' . $request->term . '%')
            ->latest()
            ->take(5)
            ->pluck('name')
            ->toArray();

        return response()->json($tags);
    }

}
