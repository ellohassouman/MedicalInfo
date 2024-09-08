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
        Schema::create('patient_sub_folders', function (Blueprint $table) {
            $table->id();
            $table->uuid('folder_number')->unique();
            $table->string('total_price');
            $table->timestamps();

            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_sub_folders');
    }
};
