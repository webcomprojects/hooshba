<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function information()
    {
        return  view('back.settings.information');
    }

    public function information_store(Request $request)
    {
        $request->validate([
            'info_site_title' => 'nullable|string|max:255',
            'info_tel' => 'nullable|string|max:20',
            'info_email' => 'nullable|string|email|max:20',
            'info_footer_text' => 'nullable|string|max:1000',
            'info_icon' => 'nullable|file|mimes:jpg,jpeg,png,webp,ico|max:2048',
            'info_logo' => 'nullable|file|mimes:jpg,jpeg,png,webp,ico|max:2048',
        ]);

        // پردازش و آپلود آیکون سایت
        if ($request->hasFile('info_icon')) {
            if (!empty(option('info_icon')) && file_exists(public_path(option('info_icon')))) {
                @unlink(public_path(option('info_icon')));
            }

            $imagePath = $this->uploadImage($request, "info_icon");
            option_update('info_icon', $imagePath); // ذخیره مسیر در دیتابیس
        }

        // پردازش و آپلود لوگو سایت
        if ($request->hasFile('info_logo')) {
            if (!empty(option('info_logo')) && file_exists(public_path(option('info_logo')))) {
                @unlink(public_path(option('info_logo')));
            }

            $imagePath = $this->uploadImage($request, "info_logo");
            option_update('info_logo', $imagePath); // ذخیره مسیر در دیتابیس
        }
          if ($request->hasFile('info_nav_logo')) {
            if (!empty(option('info_nav_logo')) && file_exists(public_path(option('info_nav_logo')))) {
                @unlink(public_path(option('info_nav_logo')));
            }

            $imagePath = $this->uploadImage($request, "info_nav_logo");
            option_update('info_nav_logo', $imagePath); // ذخیره مسیر در دیتابیس
        }

        // ذخیره سایر مقادیر فرم
        foreach ($request->except(['info_icon', 'info_logo', 'info_nav_logo']) as $information => $value) {
            option_update($information, $value);
        }


        toastr()->success('با موفقیت ذخیره شد');
        return redirect()->route('back.settings.information.index');
    }

    private function uploadImage(Request $request, $inputName)
    {

        if (!$request->hasFile($inputName)) {
            return null;
        }

        $file = $request->file($inputName);

         $request->validate([
            $inputName => 'file|mimes:jpg,jpeg,png,webp,ico|max:2048',
        ]);

        /*$fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('uploads/images', $fileName, 'public');
            return '/storage/' . $filePath;*/

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // ذخیره فایل در مسیر public/uploads/images
        $filePath = 'storage/uploads/images/settings/' . $fileName;
        $file->move(public_path('storage/uploads/images/settings'), $fileName);

        // بازگشت مسیر فایل ذخیره شده
        return '/storage/uploads/images/settings/' . $fileName;
    }

    public function socials()
    {
        return view('back.settings.socials');
    }
    public function socials_store(Request $request)
    {
        $request->validate([
            'social_telegram' => 'nullable|string|max:255',
            'social_instagram' => 'nullable|string|max:255',
            'social_whatsapp' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|string|max:255',
            'social_youtube' => 'nullable|string|max:255',
            'social_aparat' => 'nullable|string|max:255',
        ]);

        foreach ($request->all() as $information => $value) {
            option_update($information, $value);
        }


        toastr()->success('با موفقیت ذخیره شد');
        return redirect()->route('back.settings.socials.index');

    }



}
