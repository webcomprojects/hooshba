<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index()
    {
        $last_posts = Post::with('categories')->whereNull('video')->orWhere('video', 'null')->orderBy('created_at', 'desc')->take(3)->get();
        $video_posts = Post::with('categories')->whereNotNull('video')->orderBy('created_at', 'desc')->take(4)->get();
        $posts = Post::orderBy('created_at', 'desc')->take(4)->get();

        $event_posts = Post::with('categories')->whereHas('categories', function ($query) {
            $query->where('slug', 'رویداد');
        })->orderBy('created_at', 'desc')->take(10)->get();

        return view('front.index', compact('last_posts', 'video_posts','event_posts', 'posts'));
    }

    public function captcha()
    {
        return response(['captcha' => captcha_src('flat')]);
    }
}
