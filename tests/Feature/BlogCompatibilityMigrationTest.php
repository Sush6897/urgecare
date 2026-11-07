<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class BlogCompatibilityMigrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
    }

    public function test_legacy_blog_content_survives_upgrade_and_repeated_execution(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
        });
        DB::table('blogs')->insert(['name' => 'Existing title', 'description' => 'Existing content']);

        $migration = require database_path('migrations/2026_09_17_000002_update_blogs_table_add_columns.php');
        $migration->up();
        $migration->up();

        $this->assertSame('Existing title', DB::table('blogs')->value('title'));
        $this->assertSame('Existing content', DB::table('blogs')->value('content'));
        $this->assertTrue(Schema::hasColumns('blogs', ['excerpt', 'author', 'category', 'published_at']));
    }

    public function test_current_schema_survives_upgrade_and_rollback(): void
    {
        $create = require database_path('migrations/2026_09_17_000001_create_blogs_table.php');
        $create->up();
        DB::table('blogs')->insert(['title' => 'Current title', 'slug' => 'current-title', 'content' => 'Current content']);

        $migration = require database_path('migrations/2026_09_17_000002_update_blogs_table_add_columns.php');
        $migration->up();
        $migration->down();

        $this->assertSame('Current content', DB::table('blogs')->value('content'));
        $this->assertTrue(Schema::hasColumns('blogs', ['title', 'excerpt', 'author', 'category', 'published_at']));
    }
}
