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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->integer('xp_years');
            $table->timestamps();

            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_type_id')->constrained('doctor_types')->onDelete('cascade');
            $table->foreignId('health_institution_id')->nullable()->constrained('health_institutions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
