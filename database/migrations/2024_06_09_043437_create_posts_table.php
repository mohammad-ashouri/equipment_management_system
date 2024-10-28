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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->longText('body')->nullable();
            $table->text('person_and_organization')->nullable();
            $table->text('locations')->nullable();
            $table->text('times')->nullable();
            $table->text('events')->nullable();
            $table->text('equipments')->nullable();
            $table->text('contracts')->nullable();
            $table->text('other')->nullable();
            $table->text('main_subject')->nullable();
            $table->text('second_subject')->nullable();
            $table->text('third_subject')->nullable();
            $table->text('fourth_subject')->nullable();
            $table->text('source_book')->nullable();
            $table->text('volume_number')->nullable();
            $table->text('book_number')->nullable();
            $table->text('page_number')->nullable();
            $table->text('document_number')->nullable();
            $table->text('document_internal_number')->nullable();
            $table->unsignedBigInteger('document_type')->nullable();
            $table->foreign('document_type')->references('id')->on('document_types');
            $table->text('document_producer')->nullable();
            $table->text('recipient_of_document')->nullable();
            $table->date('AD_date')->nullable();
            $table->text('jalali_date')->nullable();
            $table->text('description')->nullable();
            $table->json('tags')->nullable();
            $table->json('related_items')->nullable();
            $table->json('similar_documents')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('comment_status')->default(1);
            $table->unsignedBigInteger('adder')->nullable();
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
