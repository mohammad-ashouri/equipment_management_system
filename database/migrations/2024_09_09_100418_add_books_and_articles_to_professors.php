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
        Schema::table('professors', function (Blueprint $table) {
            $table->dropColumn('scientific_works');
            $table->addColumn('json', 'books')->nullable()->after('adjective');
            $table->addColumn('json', 'articles')->nullable()->after('books');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professors', function (Blueprint $table) {
            $table->dropColumn('books');
            $table->dropColumn('articles');
            $table->addColumn('json', 'scientific_works')->nullable()->after('adjective');
        });
    }
};
