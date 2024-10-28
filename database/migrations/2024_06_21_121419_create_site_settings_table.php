<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('option');
            $table->text('value')->nullable();
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
        });

        DB::table('site_settings')->insert([
            ['option' => 'eitaa_link','value'=>'https://eitaa.com/usadoc'],
            ['option' => 'aparat_link','value'=>'#'],
            ['option' => 'virasty_link','value'=>'https://virasty.com/Usdoc'],
            ['option' => 'instagram_link','value'=>'#'],
            ['option' => 'x_link','value'=>'#'],
            ['option' => 'about_us_text','value'=>'وب سایت مرکز اسناد لانه جاسوسی در سال 1402 سال افزایش تولید طراحی و آغاز به کار نمود که به
                        بررسی اسناد لانه جاسوسی، بروز رسانی اسناد با توجه به مسائل روز و تحقیق و بررسی منابع و تطبیق
                        آن با اتفاقات در عرصه های مختلف اجتماعی، سیاسی و بین المللی انجام میدهد'],
            ['option' => 'maintenance_mode','value'=>'#'],
            ['option' => 'copyright_text','value'=>'
All Content by asnad.ir is licensed under a Creative Commons Attribution 4.0 International License.
            '],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
