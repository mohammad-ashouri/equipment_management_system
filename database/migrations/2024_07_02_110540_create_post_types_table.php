<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon');
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
        });

        $query="INSERT INTO post_types (title,adder , icon) VALUES
('اسناد', 10, 'la-file-alt'),
('اسناد خارجی', 10, 'la-passport'),
('سوژه های پژوهشی', 10, 'la-search'),
('سوژه های رسانه ای', 10, 'la-share-alt-square'),
('اساتید', 10, 'la-user-tie'),
('مستند', 10, 'la-photo-video'),
('فضای مجازی', 10, 'la-share-alt'),
('معرفی کتاب', 10, 'la-book-open'),
('یادداشت ها', 10, 'la-sticky-note'),
('کلاس اسناد', 10, 'la-school'),
('صوت', 10, 'la-file-audio'),
('فیلم', 10, 'la-video'),
('آلبوم تصویر', 10, 'la-images');
";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_types');
    }
};
