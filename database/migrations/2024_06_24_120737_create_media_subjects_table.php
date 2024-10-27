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
        Schema::create('media_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->longText('body');
            $table->unsignedBigInteger('subject_format')->default(1);
            $table->foreign('subject_format')->references('id')->on('subject_formats');
            $table->unsignedBigInteger('subject_audience')->default(1);
            $table->foreign('subject_audience')->references('id')->on('subject_audiences');
            $table->text('keywords')->nullable();
            $table->text('resources')->nullable();
            $table->json('attached_documents')->nullable();
            $table->json('related_items')->nullable();
            $table->json('similar_subjects')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('adder');
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
        Schema::dropIfExists('media_subjects');
    }
};
