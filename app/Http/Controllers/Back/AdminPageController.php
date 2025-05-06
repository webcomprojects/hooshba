<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('pages.index');
        $pages = Page::latest()->paginate(15);
        return view('back.pages.index', compact('pages'));
    }

    public function create()
    {
        $this->authorize('pages.create');
        return view('back.pages.create');
    }

    public function store(Request $request)
    {
        $this->authorize('pages.create');

        if ($request->input('slug')) {
            $slug = sluggable_helper_function($request->slug);
        } else {
            $slug = sluggable_helper_function($request->title);
        }

        $request->merge(['slug' => $slug]);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|unique:pages,slug',
            'is_published' => 'nullable|boolean|in:0,1',
        ]);

        $page = Page::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'is_published' => $request->is_published ? 1 : 0,
            'published_at' => now(),
        ]);

        toastr()->success('صفحه با موفیت ایجاد شد');
        return redirect()->route('back.pages.index');
    }

    public function edit(Page $page)
    {
        $this->authorize('pages.update');
        return view('back.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $this->authorize('pages.update');

        if ($request->input('slug')) {
            $slug = sluggable_helper_function($request->slug);
        } else {
            $slug = sluggable_helper_function($request->title);
        }

        $request->merge(['slug' => $slug]);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|unique:pages,slug,' . $page->id,
            'is_published' => 'nullable|boolean|in:0,1',
        ]);

        $page->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'is_published' => $request->is_published ? 1 : 0,
            'published_at' => now(),
        ]);

        toastr()->success('صفحه با موفیت بروزرسانی شد');
        return redirect()->route('back.pages.index');
    }

    public function destroy(Page $page)
    {
        $this->authorize('pages.delete');
        $page->delete();
        toastr()->success('صفحه با موفقیت حذف شد');
        return redirect()->route('back.pages.index');
    }
}