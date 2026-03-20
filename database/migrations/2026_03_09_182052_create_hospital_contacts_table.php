<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hospital_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->string('contact', 20);
            $table->timestamps();
        });

        // Migrate existing single contact numbers into the new table
        $hospitals = DB::table('hospitals')->whereNotNull('contact')->where('contact', '!=', '')->get();
        foreach ($hospitals as $hospital) {
            DB::table('hospital_contacts')->insert([
                'hospital_id' => $hospital->id,
                'contact'     => $hospital->contact,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_contacts');
    }
};
