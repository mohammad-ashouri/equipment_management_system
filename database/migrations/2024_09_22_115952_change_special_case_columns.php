<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('special_cases', function (Blueprint $table) {
            $table->dropColumn('multimedia');
            $table->addColumn('json', 'movies')->nullable()->after('interview_body');
            $table->addColumn('json', 'audios')->nullable()->after('movies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->json('multimedia')->nullable()->after('interview_body');
            $table->dropColumn('movies');
            $table->dropColumn('audios');
        });
    }
};
