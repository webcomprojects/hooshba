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
        Schema::create('members', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->enum('type', ['council', 'presidency'])->default('council')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('job_position')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('national_id')->nullable()->unique();
            $table->string('image')->nullable();
            $table->json('links')->nullable();
            $table->text('description')->nullable();
            $table->text('educational_background')->nullable();
            $table->text('executive_background')->nullable();

            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('restrict');


            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
