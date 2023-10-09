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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->foreignId('patient_id')->constrained('patients');
            $table->timestamp('appointment_datetime');
            $table->enum('status', ['scheduled', 'completed', 'canceled'])->default('scheduled');
            $table->boolean('canceled_by_doctor')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['doctor_id']);
            $table->dropForeign(['patient_id']);
        });

        // Drop the table
        Schema::dropIfExists('appointments');
    }
};
