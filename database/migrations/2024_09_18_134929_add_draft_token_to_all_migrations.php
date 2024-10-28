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
            $table->addColumn('string', 'draft_token')->nullable()->after('id');
        });
        Schema::table('international_documents', function (Blueprint $table) {
            $table->addColumn('string', 'draft_token')->nullable()->after('id');
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->addColumn('string', 'draft_token')->nullable()->after('id');
        });
        Schema::table('social_media', function (Blueprint $table) {
            $table->addColumn('string', 'draft_token')->nullable()->after('id');
        });
        Schema::table('documentaries', function (Blueprint $table) {
            $table->addColumn('string', 'draft_token')->nullable()->after('id');
        });
        Schema::table('document_classes', function (Blueprint $table) {
            $table->addColumn('string', 'draft_token')->nullable()->after('id');
        });
        Schema::table('media_subjects', function (Blueprint $table) {
            $table->addColumn('string', 'draft_token')->nullable()->after('id');
        });
        Schema::table('research_subjects', function (Blueprint $table) {
            $table->addColumn('string', 'draft_token')->nullable()->after('id');
        });
        Schema::table('professors', function (Blueprint $table) {
            $table->addColumn('string', 'draft_token')->nullable()->after('id');
        });
        Schema::table('special_cases', function (Blueprint $table) {
            $table->addColumn('string', 'draft_token')->nullable()->after('id');
        });
        Schema::table('book_introductions', function (Blueprint $table) {
            $table->addColumn('string', 'draft_token')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('draft_token');
        });
        Schema::table('international_documents', function (Blueprint $table) {
            $table->dropColumn('draft_token');
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn('draft_token');
        });
        Schema::table('social_media', function (Blueprint $table) {
            $table->dropColumn('draft_token');
        });
        Schema::table('documentaries', function (Blueprint $table) {
            $table->dropColumn('draft_token');
        });
        Schema::table('document_classes', function (Blueprint $table) {
            $table->dropColumn('draft_token');
        });
        Schema::table('media_subjects', function (Blueprint $table) {
            $table->dropColumn('draft_token');
        });
        Schema::table('research_subjects', function (Blueprint $table) {
            $table->dropColumn('draft_token');
        });
        Schema::table('professors', function (Blueprint $table) {
            $table->dropColumn('draft_token');
        });
        Schema::table('special_cases', function (Blueprint $table) {
            $table->dropColumn('draft_token');
        });
        Schema::table('book_introductions', function (Blueprint $table) {
            $table->dropColumn('draft_token');
        });
    }
};
