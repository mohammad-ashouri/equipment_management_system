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
        Schema::create('book_introductions', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->longText('body')->nullable();
            $table->text('keywords')->nullable();
            $table->string('book_title')->nullable();
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->string('subjects')->nullable();
            $table->longText('hint')->nullable();
            $table->json('similar_books')->nullable();
            $table->json('related_items')->nullable();
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
        Schema::dropIfExists('book_introductions');
    }
};
