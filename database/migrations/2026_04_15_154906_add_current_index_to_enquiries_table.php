<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('enquiries', function (Blueprint $table) {
        $table->integer('current_index')->default(0)->after('status');
    });
}

public function down()
{
    Schema::table('enquiries', function (Blueprint $table) {
        $table->dropColumn('current_index');
    });
}
};
