<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('call_logs', function (Blueprint $table) {
            $table->id();
            $table->string('from_number');
            $table->json('numbers');
            $table->unsignedInteger('current_index')->default(0);
            $table->string('call_sid')->nullable();
            $table->string('status')->default('in_progress');
            $table->string('last_exotel_status')->nullable();
            $table->json('attempts')->nullable();
            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->string('patient_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('call_logs');
    }
};
