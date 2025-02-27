<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminIntroductionController extends Controller
{
    public function index()
    {
        return view('back.introduction.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'introduction_title' => 'required|string|max:255',
            'introduction_shortContent' => 'required|string|max:1000',
            'introduction_content' => 'nullable|string|max:5000',
            'introduction_video' => 'nullable|string|max:1000',
            'introduction_featured_image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'introduction_is_published' => 'nullable|boolean|in:0,1',
        ]);

        if ($request->hasFile('featured_image')) {

            if (!empty(option('introduction_featured_image')) && file_exists(public_path(option('introduction_featured_image')))) {
                if (is_file(public_path(option('introduction_featured_image')))) {
                    unlink(public_path(option('introduction_featured_image')));
                }
            }

            $imagePath = $this->uploadImage($request);
            $request->merge(['introduction_featured_image' => $imagePath]);
        }

        foreach ($request->all() as $information => $value) {
            if($information!="featured_image"){
                option_update($information, $value);
            }

        }

        toastr()->success('با موفقیت ذخیره شد');
        return redirect()->route('back.about-us.introduction.index');
    }

    private function uploadImage(Request $request, $inputName = 'featured_image')
    {

        if (!$request->hasFile($inputName)) {
            return null;
        }

        $file = $request->file($inputName);

        $validated = $request->validate([
            $inputName => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        /*$fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('uploads/images', $fileName, 'public');
            return '/storage/' . $filePath;*/

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // ذخیره فایل در مسیر public/uploads/images
        $filePath = 'storage/uploads/images/introduction/' . $fileName;
        $file->move(public_path('storage/uploads/images/introduction'), $fileName);

        // بازگشت مسیر فایل ذخیره شده
        return '/storage/uploads/images/introduction/' . $fileName;
    }


}
