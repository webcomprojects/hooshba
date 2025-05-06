<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with('user')->latest()->paginate(10);
        return response()->json($pages);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'is_published' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page = Page::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug ?? Str::slug($request->title),
            'is_published' => $request->is_published ?? false,
            'user_id' => Auth::id(),
        ]);

        return response()->json($page, 201);
    }

    public function show(Page $page)
    {
        return response()->json($page->load('user'));
    }

    public function update(Request $request, Page $page)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'is_published' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug ?? Str::slug($request->title),
            'is_published' => $request->is_published ?? false,
        ]);

        return response()->json($page);
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return response()->json(null, 204);
    }

    public function published()
    {
        $pages = Page::with('user')
            ->where('is_published', true)
            ->latest()
            ->paginate(10);
        return response()->json($pages);
    }

    public function draft()
    {
        $pages = Page::with('user')
            ->where('is_published', false)
            ->latest()
            ->paginate(10);
        return response()->json($pages);
    }

    public function frontAllPages()
    {
        $pages = Page::with('user')
            ->where('is_published', true)
            ->latest()
            ->paginate(10);
        return response()->json($pages);
    }

    public function frontSinglePage($slug)
    {
        $page = Page::with('user')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        return response()->json($page);
    }
}