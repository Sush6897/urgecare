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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('hospital_name');
            $table->text('address');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('pincode');
            $table->string('features1')->nullable();
            $table->string('features2')->nullable();
            $table->string('features3')->nullable();
            $table->string('features4')->nullable();
            $table->string('gmap');
            $table->decimal('longitude', 10, 7);
            $table->decimal('latitude', 10, 7);
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
