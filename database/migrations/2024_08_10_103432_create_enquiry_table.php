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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();                    // Auto-incrementing ID
            $table->string('patient_name')->nullable();  // Add patient_name column
            $table->unsignedBigInteger('hospital_id')->nullable(); // Add hospital_id column
            $table->string('sid');           // Call SID from Exotel
            $table->string('from');          // The caller's phone number
            $table->string('to');            // The recipient's phone number
            $table->string('status')->default('pending'); // Add status column with default value
            $table->timestamps();            // created_at and updated_at columns

            // If you have a hospitals table, create a foreign key constraint
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiry');
    }
};
