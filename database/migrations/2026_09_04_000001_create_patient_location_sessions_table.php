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
        Schema::create('patient_location_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_token', 64)->unique();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('start_latitude')->nullable();
            $table->string('start_longitude')->nullable();
            $table->string('current_latitude')->nullable();
            $table->string('current_longitude')->nullable();
            $table->enum('movement_status', ['stopped', 'walking'])->default('stopped');
            $table->float('current_speed')->default(0); // in km/h
            $table->float('total_distance_meters')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_location_sessions');
    }
};
