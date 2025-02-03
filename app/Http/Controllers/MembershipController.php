<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use Illuminate\Validation\Rule;

class MembershipController extends Controller
{
    public function store(Request $request)
    {
        //  عمومی
        $commonRules = [
            'user_type' => 'required|in:individual,corporate',
            'email' => 'required|email|unique:memberships,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'membership_type' => 'required|string',
            'membership_fee' => 'required|integer|min:0',
            'ai_experience' => 'nullable|string',
        ];

        // حقیقی
        $individualRules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'national_id' => 'required|string|unique:memberships,national_id',
            'birth_date' => 'nullable|date',
            'degree' => 'nullable|string|max:255',
            'university' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'graduation_year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'job_title' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'start_year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'end_year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'resume_path' => 'nullable|file|mimes:pdf|max:1024',
            'degree_certificate_path' => 'nullable|file|mimes:pdf|max:1024',
            'national_card_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        // حقوقی
        $corporateRules = [
            'company_name_corporate' => 'required|string|max:255',
            'company_name_en' => 'nullable|string|max:255',
            'company_national_id' => 'required|string|unique:memberships,company_national_id',
            'company_phone' => 'required|string|max:20',
            'company_established_date' => 'nullable|date',
            'representative_name' => 'required|string|max:255',
            'representative_national_id' => 'required|string|max:20',
            'website' => 'nullable|url',
            'representative_phone' => 'nullable|string|max:20',
            'company_logo_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_registration_doc' => 'nullable|file|mimes:pdf|max:2048',
        ];

        $rules = $request->user_type === 'individual' ? array_merge($commonRules, $individualRules) : array_merge($commonRules, $corporateRules);

        $validatedData = $request->validate($rules);

        $membership = new Membership();
        $membership->fill($validatedData);

        // آپلود فایل‌ها
        if ($request->hasFile('resume_path')) {
            $membership->resume_path = $this->uploadFile($request, 'resume_path', 'uploads/memberships/resumes');
        }
        if ($request->hasFile('degree_certificate_path')) {
            $membership->degree_certificate_path = $this->uploadFile($request, 'degree_certificate_path', 'uploads/memberships/certificates');
        }
        if ($request->hasFile('national_card_path')) {
            $membership->national_card_path = $this->uploadFile($request, 'national_card_path', 'uploads/memberships/national_cards');
        }
        if ($request->hasFile('company_logo_path')) {
            $membership->company_logo_path = $this->uploadFile($request, 'company_logo_path', 'uploads/memberships/company_logos');
        }
        if ($request->hasFile('company_registration_doc')) {
            $membership->company_registration_doc = $this->uploadFile($request, 'company_registration_doc', 'uploads/memberships/registration_docs');
        }

        $membership->save();

        return response()->json(['message' => 'عضویت با موفقیت ثبت شد', 'data' => $membership], 201);
    }

    private function uploadFile(Request $request, $inputName, $folderPath)
    {
        try {
            if (!$request->hasFile($inputName)) {
                return null;
            }

            $file = $request->file($inputName);
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = 'storage/' . $folderPath . '/' . $fileName;
            $file->move(public_path('storage/' . $folderPath), $fileName);
            return '/' . $filePath;
        } catch (\Exception $e) {
            throw new \Exception('آپلود فایل با شکست مواجه شد: ' . $e->getMessage());
        }
    }
}
