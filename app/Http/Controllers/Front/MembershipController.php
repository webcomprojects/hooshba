<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\EducationHistory;
use App\Models\JobHistory;
use Illuminate\Http\Request;
use App\Models\Membership;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Str;

class MembershipController extends Controller
{
    public function index()
    {
        return view('front.membership.index');
    }
    public function store(Request $request)
    {

        $birth_date = null;
        if ($request->birth_date) {
            $birth_date = explode('-', $request->birth_date);
            if (count($birth_date) >= 2) {
                $birth_date = to_english_numbers($birth_date[0]) . '-' . to_english_numbers($birth_date[1]) . '-' . to_english_numbers($birth_date[2]);
                $request->merge(['birth_date' => $birth_date]);
            }
        }

        $company_established_date = null;
        if ($request->company_established_date) {
            $company_established_date = explode('-', $request->company_established_date);
            if (count($company_established_date) >= 2) {
                $company_established_date = to_english_numbers($company_established_date[0]) . '-' . to_english_numbers($company_established_date[1]) . '-' . to_english_numbers($company_established_date[2]);
                $request->merge(['company_established_date' => $company_established_date]);
            }
        }


        //  عمومی
        $commonRules = [
            'user_type' => 'required|in:individual,corporate',

            'address' => 'required|string',
            'address2' => 'nullable|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|digits:10',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer|min:0',
            'final_approval' => 'required|in:1',
            'ai_experience' => 'nullable|string',
        ];

        // حقیقی
        $individualRules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:memberships,email',
            'phone' => 'required|digits:11|regex:/^[0][9][0-9]{9,9}$/',
            'national_id' => 'required|string|digits:10|unique:memberships,national_id',
            'referral_code' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'degree' => 'nullable|string|max:255',
            'university' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'graduation_year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'job_title' => 'nullable|string|max:255',
            'start_year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'end_year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'resume_file' => 'required|file|mimes:pdf|max:1024',
            'degree_certificate_image' => 'required|file|mimes:pdf|max:1024',
            'national_card_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',

            'education_histories' => 'nullable|array',
            'education_histories.*.degree' => 'nullable|string',
            'education_histories.*.country' => 'nullable|string',
            'education_histories.*.institution' => 'nullable|string',
            'education_histories.*.field_of_study' => 'nullable|string',
            'education_histories.*.specialization' => 'nullable|string',
            'education_histories.*.graduation_year' => 'nullable|integer',
            'job_histories' => 'nullable|array',
            'job_histories.*.company' => 'required|string',
            'job_histories.*.position' => 'required|string',
            'job_histories.*.start_year' => 'required|integer',
            'job_histories.*.end_year' => 'nullable|integer',



            'experience_ai_description' => 'nullable|max:550',
        ];

        // حقوقی
        $corporateRules = [
            'company_name' => 'nullable|string|max:255',
            'company_name_en' => 'nullable|string|max:255',
            'company_national_id' => 'required|string|unique:memberships,company_national_id',
            'company_registration_number' => 'required|string|unique:memberships,company_registration_number',
            //'company_phone' => 'required|string|max:20',
            'company_established_date' => 'nullable|date',
            'representative_name' => 'required|string|max:255',
            'representative_national_id' => 'required|string|max:20',
            'email_company' => 'required|string|email',
            'representative_email' => 'required|string|email',
           'website' => ['nullable', 'regex:/^(https?:\/\/)?(www\.)?[\w\-]+\.[a-z]{2,6}(\.[a-z]{2,6})?(\/.*)?$/i'],
            'representative_phone' => 'nullable|string|max:20',
            'company_logo_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_registration_doc' => 'nullable|file|mimes:pdf|max:2048',

            'experience_ai_description' => 'nullable|max:1650',
        ];
        $messages = [
            'user_type.required' => 'نوع کاربر الزامی است.',
            'user_type.in' => 'نوع کاربر باید یکی از مقادیر individual یا corporate باشد.',

            'email.required' => 'وارد کردن ایمیل الزامی است.',
            'email.email' => 'فرمت ایمیل صحیح نیست.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',

            'phone.required' => 'شماره تلفن الزامی است.',
            'phone.digits' => 'شماره تلفن باید شامل 11 رقم باشد.',
            'phone.regex' => 'فرمت شماره تلفن صحیح نیست.',

            'address.required' => 'آدرس الزامی است.',
            'address.string' => 'آدرس باید شامل متن باشد.',

            'city.required' => 'شهر الزامی است.',
            'city.string' => 'نام شهر باید شامل متن باشد.',
            'city.max' => 'نام شهر نباید بیش از 100 کاراکتر باشد.',

            'state.required' => 'استان الزامی است.',
            'state.string' => 'نام استان باید شامل متن باشد.',
            'state.max' => 'نام استان نباید بیش از 100 کاراکتر باشد.',

            'country.required' => 'کشور الزامی است.',
            'country.string' => 'نام کشور باید شامل متن باشد.',
            'country.max' => 'نام کشور نباید بیش از 100 کاراکتر باشد.',

            'postal_code.required' => 'کد پستی الزامی است.',
            'postal_code.string' => 'کد پستی باید شامل متن باشد.',
            'postal_code.digits' => 'کد پستی باید دقیقاً 10 رقم باشد.',

            'membership_type.required' => 'نوع عضویت الزامی است.',
            'membership_type.string' => 'نوع عضویت باید شامل متن باشد.',

            'membership_fee.required' => 'هزینه عضویت الزامی است.',
            'membership_fee.integer' => 'هزینه عضویت باید یک عدد صحیح باشد.',
            'membership_fee.min' => 'هزینه عضویت نمی‌تواند منفی باشد.',

            'first_name.required' => 'نام الزامی است.',
            'first_name.string' => 'نام باید شامل متن باشد.',
            'first_name.max' => 'نام نباید بیش از 255 کاراکتر باشد.',

            'last_name.required' => 'نام خانوادگی الزامی است.',
            'last_name.string' => 'نام خانوادگی باید شامل متن باشد.',
            'last_name.max' => 'نام خانوادگی نباید بیش از 255 کاراکتر باشد.',

            'national_id.required' => 'کد ملی الزامی است.',
            'national_id.string' => 'کد ملی باید شامل متن باشد.',
            'national_id.digits' => 'کد ملی باید دقیقاً 10 رقم باشد.',
            'national_id.unique' => 'کد ملی قبلاً ثبت شده است.',

            'birth_date.date' => 'فرمت تاریخ تولد صحیح نیست.',

            'degree.max' => 'مدرک تحصیلی نباید بیش از 255 کاراکتر باشد.',

            'university.max' => 'نام دانشگاه نباید بیش از 255 کاراکتر باشد.',

            'field_of_study.max' => 'رشته تحصیلی نباید بیش از 255 کاراکتر باشد.',

            'graduation_year.digits' => 'سال فارغ‌التحصیلی باید 4 رقم باشد.',
            'graduation_year.integer' => 'سال فارغ‌التحصیلی باید یک عدد صحیح باشد.',
            'graduation_year.min' => 'سال فارغ‌التحصیلی نمی‌تواند قبل از 1900 باشد.',
            'graduation_year.max' => 'سال فارغ‌التحصیلی نمی‌تواند بیشتر از سال جاری باشد.',

            'job_title.max' => 'عنوان شغلی نباید بیش از 255 کاراکتر باشد.',

            'company_name.max' => 'نام شرکت نباید بیش از 255 کاراکتر باشد.',

            'start_year.digits' => 'سال شروع باید 4 رقم باشد.',
            'start_year.integer' => 'سال شروع باید یک عدد صحیح باشد.',
            'start_year.min' => 'سال شروع نمی‌تواند قبل از 1900 باشد.',
            'start_year.max' => 'سال شروع نمی‌تواند بیشتر از سال جاری باشد.',

            'end_year.digits' => 'سال پایان باید 4 رقم باشد.',
            'end_year.integer' => 'سال پایان باید یک عدد صحیح باشد.',
            'end_year.min' => 'سال پایان نمی‌تواند قبل از 1900 باشد.',
            'end_year.max' => 'سال پایان نمی‌تواند بیشتر از سال جاری باشد.',

            'resume_path.file' => 'فایل رزومه باید یک فایل معتبر باشد.',
            'resume_path.mimes' => 'فرمت رزومه باید PDF باشد.',
            'resume_path.max' => 'حجم فایل رزومه نباید بیشتر از 1 مگابایت باشد.',

            'degree_certificate_path.file' => 'مدرک تحصیلی باید یک فایل معتبر باشد.',
            'degree_certificate_path.mimes' => 'فرمت مدرک تحصیلی باید PDF باشد.',
            'degree_certificate_path.max' => 'حجم مدرک تحصیلی نباید بیشتر از 1 مگابایت باشد.',

            'national_card_path.file' => 'تصویر کارت ملی باید یک فایل معتبر باشد.',
            'national_card_path.mimes' => 'فرمت کارت ملی باید JPEG, PNG, JPG, GIF یا SVG باشد.',
            'national_card_path.max' => 'حجم کارت ملی نباید بیشتر از 2 مگابایت باشد.',

            'education_histories.*.degree.string' => 'مدرک تحصیلی باید شامل متن باشد.',
            'education_histories.*.country.string' => 'کشور باید شامل متن باشد.',
            'education_histories.*.institution.string' => 'نام موسسه آموزشی باید شامل متن باشد.',
            'education_histories.*.field_of_study.string' => 'رشته تحصیلی باید شامل متن باشد.',
            'education_histories.*.specialization.string' => 'تخصص باید شامل متن باشد.',
            'education_histories.*.graduation_year.integer' => 'سال فارغ‌التحصیلی باید یک عدد صحیح باشد.',

            'job_histories.*.company.required' => 'نام شرکت در سابقه شغلی الزامی است.',
            'job_histories.*.company.string' => 'نام شرکت باید شامل متن باشد.',

            'job_histories.*.position.required' => 'عنوان شغلی در سابقه شغلی الزامی است.',
            'job_histories.*.position.string' => 'عنوان شغلی باید شامل متن باشد.',

            'job_histories.*.start_year.required' => 'سال شروع در سابقه شغلی الزامی است.',
            'job_histories.*.start_year.integer' => 'سال شروع باید یک عدد صحیح باشد.',

            'job_histories.*.end_year.integer' => 'سال پایان باید یک عدد صحیح باشد.',

            'experience_ai_description.max' => 'توضیحات تجربه هوش مصنوعی نباید بیش از 550 کاراکتر باشد.',

            'company_name_corporate.required' => 'نام شرکت الزامی است.',
            'company_name_corporate.string' => 'نام شرکت باید شامل متن باشد.',
            'company_name_corporate.max' => 'نام شرکت نباید بیش از 255 کاراکتر باشد.',

            'company_national_id.required' => 'شناسه ملی شرکت الزامی است.',
            'company_national_id.unique' => 'شناسه ملی شرکت قبلاً ثبت شده است.',

            'company_registration_number.required' => 'شماره ثبت شرکت الزامی است.',
            'company_registration_number.unique' => 'شماره ثبت شرکت قبلاً ثبت شده است.',

            'company_phone.required' => 'شماره تلفن شرکت الزامی است.',
            'company_phone.string' => 'شماره تلفن شرکت باید شامل متن باشد.',
            'company_phone.max' => 'شماره تلفن شرکت نباید بیش از 20 کاراکتر باشد.',

            'representative_name.required' => 'نام نماینده شرکت الزامی است.',
            'representative_name.string' => 'نام نماینده شرکت باید شامل متن باشد.',
            'representative_name.max' => 'نام نماینده شرکت نباید بیش از 255 کاراکتر باشد.',

            'representative_national_id.required' => 'کد ملی نماینده شرکت الزامی است.',
            'representative_national_id.string' => 'کد ملی نماینده شرکت باید شامل متن باشد.',

            'website.url' => 'فرمت آدرس وب‌سایت معتبر نیست.',

            'company_registration_doc.file' => 'فایل ثبت شرکت باید یک فایل معتبر باشد.',
            'company_registration_doc.mimes' => 'فرمت فایل ثبت شرکت باید PDF باشد.',
            'company_registration_doc.max' => 'حجم فایل ثبت شرکت نباید بیشتر از 2 مگابایت باشد.',
        ];

        $rules = $request->user_type === 'individual' ? array_merge($commonRules, $individualRules) : array_merge($commonRules, $corporateRules);

        if (isset($request->experience_ai)) {
            $request->merge([
                'ai_experience' => json_encode($request->input('experience_ai', []))
            ]);
        } elseif (isset($request->corporate_experience_ai)) {
            $request->merge([
                'ai_experience' => json_encode($request->input('corporate_experience_ai', []))
            ]);
        }

        $validatedData = $request->validate($rules, $messages);

        // ذخیره `membership`

        $membership = Membership::create(array_merge($validatedData, ['id' => Str::uuid()]));

        // ذخیره `education_histories`
        if (!empty($request->education_histories)) {
            foreach ($request->education_histories as $education) {
                if ($education['degree']) {
                    EducationHistory::create([
                        'id' => Str::uuid(),
                        'membership_id' => $membership->id,
                        'degree' => $education['degree'] ?? null,
                        'country' => $education['country'] ?? null,
                        'institution' => $education['institution'] ?? null,
                        'field_of_study' => $education['field_of_study'] ?? null,
                        'specialization' => $education['specialization'] ?? null,
                        'graduation_year' => $education['graduation_year'] ?? null,
                    ]);
                }
            }
        }

        // ذخیره `job_histories`
        if (!empty($request->job_histories)) {
            foreach ($request->job_histories as $job) {
                if ($job['company']) {
                    JobHistory::create([
                        'id' => Str::uuid(),
                        'membership_id' => $membership->id,
                        'company' => $job['company'],
                        'position' => $job['position'],
                        'start_year' => $job['start_year'],
                        'end_year' => $job['end_year'] ?? null,
                    ]);
                }
            }
        }


        // آپلود فایل‌ها
        if ($request->hasFile('resume_file')) {
            $membership->resume_file = $this->uploadFile($request, 'resume_file', 'uploads/memberships/resumes');
        }
        if ($request->hasFile('degree_certificate_image')) {
            $membership->degree_certificate_image = $this->uploadFile($request, 'degree_certificate_image', 'uploads/memberships/certificates');
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


        toastr()->success('عضویت با موفقیت انجام شد');
        return redirect('/');
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
