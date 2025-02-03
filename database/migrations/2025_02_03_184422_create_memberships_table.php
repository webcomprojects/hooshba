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
            $table->bigIncrements('id');

              // نوع کاربر (حقیقی یا حقوقی)
              $table->enum('user_type', ['individual', 'corporate']);

              // فیلدهای مشترک
              $table->string('email')->unique();
              $table->string('phone');
              $table->text('address');
              $table->string('city');
              $table->string('state');
              $table->string('country');
              $table->string('postal_code');
              $table->string('membership_type');
              $table->integer('membership_fee');
              $table->text('ai_experience')->nullable();

              // اطلاعات حقیقی
              $table->string('first_name')->nullable();
              $table->string('last_name')->nullable();
              $table->string('father_name')->nullable();
              $table->string('national_id')->unique()->nullable();
              $table->date('birth_date')->nullable();
              $table->string('degree')->nullable();
              $table->string('university')->nullable();
              $table->string('field_of_study')->nullable();
              $table->year('graduation_year')->nullable();
              $table->string('job_title')->nullable();
              $table->string('company_name')->nullable();
              $table->year('start_year')->nullable();
              $table->year('end_year')->nullable();

              // اطلاعات حقوقی
              $table->string('company_name_corporate')->nullable();
              $table->string('company_name_en')->nullable();
              $table->string('company_national_id')->nullable()->unique();
              $table->string('company_phone')->nullable();
              $table->date('company_established_date')->nullable();
              $table->string('representative_name')->nullable();
              $table->string('representative_national_id')->nullable();
              $table->string('website')->nullable();
              $table->string('representative_phone')->nullable();

              // فایل‌ها
              $table->string('resume_path')->nullable();
              $table->string('degree_certificate_path')->nullable();
              $table->string('national_card_path')->nullable();
              $table->string('company_logo_path')->nullable();
              $table->string('company_registration_doc')->nullable();

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
