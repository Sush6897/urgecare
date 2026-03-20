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
        Schema::table('hospitals', function (Blueprint $table) {
            $table->index('hospital_name');
            $table->index('pincode');
            $table->index('status');
            $table->index('emergency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->dropIndex(['hospital_name']);
            $table->dropIndex(['pincode']);
            $table->dropIndex(['status']);
            $table->dropIndex(['emergency']);
        });
    }
};
