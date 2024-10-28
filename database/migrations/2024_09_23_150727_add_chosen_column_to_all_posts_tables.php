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
        Schema::table('posts', function (Blueprint $table) {
            $table->addColumn('boolean', 'chosen')->default(0)->after('status');
        });
        Schema::table('international_documents', function (Blueprint $table) {
            $table->addColumn('boolean', 'chosen')->default(0)->after('status');
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->addColumn('boolean', 'chosen')->default(0)->after('status');
        });
        Schema::table('social_media', function (Blueprint $table) {
            $table->addColumn('boolean', 'chosen')->default(0)->after('status');
        });
        Schema::table('documentaries', function (Blueprint $table) {
            $table->addColumn('boolean', 'chosen')->default(0)->after('status');
        });
        Schema::table('document_classes', function (Blueprint $table) {
            $table->addColumn('boolean', 'chosen')->default(0)->after('status');
        });
        Schema::table('media_subjects', function (Blueprint $table) {
            $table->addColumn('boolean', 'chosen')->default(0)->after('status');
        });
        Schema::table('research_subjects', function (Blueprint $table) {
            $table->addColumn('boolean', 'chosen')->default(0)->after('status');
        });
        Schema::table('professors', function (Blueprint $table) {
            $table->addColumn('boolean', 'chosen')->default(0)->after('status');
        });
        Schema::table('special_cases', function (Blueprint $table) {
            $table->addColumn('boolean', 'chosen')->default(0)->after('status');
        });
        Schema::table('book_introductions', function (Blueprint $table) {
            $table->addColumn('boolean', 'chosen')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('chosen');
        });
        Schema::table('international_documents', function (Blueprint $table) {
            $table->dropColumn('chosen');
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn('chosen');
        });
        Schema::table('social_media', function (Blueprint $table) {
            $table->dropColumn('chosen');
        });
        Schema::table('documentaries', function (Blueprint $table) {
            $table->dropColumn('chosen');
        });
        Schema::table('document_classes', function (Blueprint $table) {
            $table->dropColumn('chosen');
        });
        Schema::table('media_subjects', function (Blueprint $table) {
            $table->dropColumn('chosen');
        });
        Schema::table('research_subjects', function (Blueprint $table) {
            $table->dropColumn('chosen');
        });
        Schema::table('professors', function (Blueprint $table) {
            $table->dropColumn('chosen');
        });
        Schema::table('special_cases', function (Blueprint $table) {
            $table->dropColumn('chosen');
        });
        Schema::table('book_introductions', function (Blueprint $table) {
            $table->dropColumn('chosen');
        });
    }
};
