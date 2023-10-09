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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id');
            $table->string('disease');
            $table->string('medication');
            $table->string('dosage');
            $table->text('instructions');
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('appointment_id')->references('id') ->on('appointments')->onDelete('cascade'); // This ensures that when an appointment is deleted, its associated prescriptions are also deleted.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['appointment_id']);
        });
    }
};
