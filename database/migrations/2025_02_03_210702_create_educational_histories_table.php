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
        Schema::create('education_histories', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();

            $table->uuid('membership_id')->nullable();
            $table->foreign('membership_id')->references('id')->on('memberships')->onDelete('cascade');

            $table->string('degree')->nullable();;
            $table->string('country')->nullable();;
            $table->string('institution')->nullable();;
            $table->string('field_of_study')->nullable();;
            $table->string('specialization')->nullable();
            $table->integer('graduation_year')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_histories');
    }
};
