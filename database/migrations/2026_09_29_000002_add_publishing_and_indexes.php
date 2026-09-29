<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->timestamp('published_at')->nullable()->after('content');

            // The public blog filters to published rows and orders them newest
            // first; without this every request is a filesort over the table.
            $table->index(['published_at', 'created_at']);
        });

        Schema::table('products', function (Blueprint $table) {
            // `/store` groups and counts by category, `/store/category/{x}`
            // filters on it.
            $table->index('category');

            // `null` means "not for sale" rather than "free", so partial-list
            // queries and the admin filters both hit this.
            $table->index('price');
        });

        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->index('created_at');
        });

        Schema::table('subscribers', function (Blueprint $table) {
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('published_at');
            $table->dropIndex(['published_at', 'created_at']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['price']);
        });

        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('subscribers', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });
    }
};
