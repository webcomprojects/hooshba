<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();

              // نوع کاربر (حقیقی یا حقوقی)
              $table->enum('user_type', ['individual', 'corporate']);

              // فیلدهای مشترک
              $table->string('email')->nullable()->unique();
              $table->string('phone')->nullable();
              $table->text('address');
              $table->text('address2')->nullable();
              $table->string('city');
              $table->string('state');
              $table->string('country');
              $table->string('postal_code');
              $table->string('membership_type')->nullable();
              $table->integer('membership_fee')->nullable();
              $table->text('ai_experience')->nullable();
              $table->text('experience_ai_description')->nullable();

              // اطلاعات حقیقی
              $table->string('first_name')->nullable();
              $table->string('last_name')->nullable();
              $table->string('referral_code')->nullable();
              $table->string('referral_name')->nullable();
              $table->string('birth_certificate_number')->unique()->nullable();
              $table->date('birth_date')->nullable();

            //   جدول جدا در نظر گرفته شده
            //   $table->string('degree')->nullable();
            //   $table->string('university')->nullable();
            //   $table->string('field_of_study')->nullable();
            //   $table->year('graduation_year')->nullable();

            //   $table->string('job_title')->nullable();
            //   $table->year('start_year')->nullable();
            //   $table->year('end_year')->nullable();

              // اطلاعات حقوقی
              $table->string('company_name')->nullable();
              $table->string('company_name_en')->nullable();
              $table->string('company_national_id')->nullable()->unique();
              $table->string('company_registration_number')->nullable()->unique();
              $table->string('company_phone')->nullable();
              $table->date('company_established_date')->nullable();
              $table->string('representative_name')->nullable();
              $table->string('representative_national_id')->nullable();
              $table->string('email_company')->nullable();
              $table->string('representative_email')->nullable();
              $table->string('website')->nullable();
              $table->string('representative_phone')->nullable();

              // فایل‌ها
              $table->string('resume_file')->nullable();
              $table->string('degree_certificate_image')->nullable();
              $table->string('national_card_path')->nullable();
              $table->string('company_logo_path')->nullable();
              $table->string('company_registration_doc')->nullable();


              $table->boolean('final_approval')->default(false);



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
