<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * The blogs table already exists with columns: id, name, slug, description, image, status, created_at, updated_at
     * We rename name -> title, description -> content and add missing columns.
     */
    public function up(): void
    {
        if (Schema::hasColumn('blogs', 'name') && ! Schema::hasColumn('blogs', 'title')) {
            Schema::table('blogs', fn (Blueprint $table) => $table->renameColumn('name', 'title'));
        }

        if (Schema::hasColumn('blogs', 'description') && ! Schema::hasColumn('blogs', 'content')) {
            Schema::table('blogs', fn (Blueprint $table) => $table->renameColumn('description', 'content'));
        }

        Schema::table('blogs', function (Blueprint $table) {
            foreach (['excerpt', 'author', 'category'] as $column) {
                if (! Schema::hasColumn('blogs', $column)) {
                    $table->string($column)->nullable();
                }
            }

            if (! Schema::hasColumn('blogs', 'published_at')) {
                $table->timestamp('published_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This compatibility migration may perform no changes on modern schemas.
        // Keep data and columns owned by the original create migration on rollback.
    }
};
