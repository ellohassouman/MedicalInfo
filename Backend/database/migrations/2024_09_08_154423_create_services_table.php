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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('service_price', 10, 2);
            $table->date('service_date');
            $table->date('control_time');


            $table->foreignId('patient_sub_folder_id')->constrained('patient_sub_folders')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('health_institution_id')->constrained('health_institutions')->onDelete('cascade');
            $table->foreignId('tariff_id')->constrained('tariffs')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
