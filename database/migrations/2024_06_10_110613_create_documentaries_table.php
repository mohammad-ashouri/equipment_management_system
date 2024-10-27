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
        Schema::create('documentaries', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->string('type')->default('مستند');
            $table->tinyInteger('suggested')->default(0);
            $table->longText('body');
            $table->string('video_link')->nullable();
            $table->unsignedBigInteger('subject')->nullable();
            $table->foreign('subject')->references('id')->on('multimedia_subjects');
            $table->text('keywords')->nullable();
            $table->json('related_items')->nullable();
            $table->json('similar_documentaries')->nullable();
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
        Schema::dropIfExists('documentaries');
    }
};
