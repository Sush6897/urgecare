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
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('is_emergency_link')->default(0);
            $table->boolean('is_call_icon')->default(0);
            $table->boolean('is_whatsapp_icon')->default(0);
            $table->string('whatsapp_number')->nullable();
            $table->string('secondary_call_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['is_emergency_link', 'is_call_icon', 'is_whatsapp_icon', 'whatsapp_number', 'secondary_call_number']);
        });
    }
};
