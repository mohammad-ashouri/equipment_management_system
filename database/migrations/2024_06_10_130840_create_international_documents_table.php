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
        Schema::create('international_documents', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->longText('body')->nullable();
            $table->text('keywords')->nullable();
            $table->text('person_and_organization')->nullable();
            $table->text('locations')->nullable();
            $table->text('times')->nullable();
            $table->text('events')->nullable();
            $table->text('equipments')->nullable();
            $table->text('contracts')->nullable();
            $table->text('other')->nullable();
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
        Schema::dropIfExists('international_documents');
    }
};
