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
        Schema::create('patient_location_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('patient_location_sessions')->onDelete('cascade');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->float('speed')->default(0); // in km/h
            $table->enum('movement_status', ['stopped', 'walking'])->default('stopped');
            $table->float('accuracy')->nullable();
            $table->timestamp('recorded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_location_logs');
    }
};
