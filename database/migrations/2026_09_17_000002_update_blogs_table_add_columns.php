<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * The blogs table already exists with columns: id, name, slug, description, image, status, created_at, updated_at
     * We rename name -> title, description -> content and add missing columns.
     */
    public function up(): void
    {
        // Use CHANGE for older MariaDB that doesn't support RENAME COLUMN
        DB::statement('ALTER TABLE `blogs` CHANGE `name` `title` VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE `blogs` CHANGE `description` `content` LONGTEXT NOT NULL');

        Schema::table('blogs', function (Blueprint $table) {
            $table->string('excerpt')->nullable()->after('content');
            $table->string('author')->nullable()->after('excerpt');
            $table->string('category')->nullable()->after('author');
            $table->timestamp('published_at')->nullable()->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['excerpt', 'author', 'category', 'published_at']);
        });

        DB::statement('ALTER TABLE `blogs` CHANGE `title` `name` VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE `blogs` CHANGE `content` `description` LONGTEXT NOT NULL');
    }
};
