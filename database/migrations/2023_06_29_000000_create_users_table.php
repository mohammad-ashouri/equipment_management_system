<?php

use App\Models\User;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('family');
            $table->string('username')->unique();
            $table->string('password');
            $table->tinyInteger('type')->comment('
            1 => SuperAdmin
            ');
            $table->string('subject');
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('ntcp')->default(0)->comment('Needs To Change Password');
            $table->text('user_image')->nullable();
            $table->unsignedBigInteger('building')->nullable();
            $table->string('room_number')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        $password = bcrypt(12345678);

        User::insert([
            ['id'=>1,'username'=>'admin','password'=>$password,'name'=>'Super','family'=>'Admin','type'=>1,'subject'=>'ادمین کل','active'=>1,'ntcp'=>0],
            ['id'=>2,'username'=>'bodaghi','password'=>$password,'name'=>'علی اصغر','family'=>'بداغی','type'=>2,'subject'=>'کارشناس فنی','active'=>1,'ntcp'=>0],
            ['id'=>3,'username'=>'ehtesham','password'=>$password,'name'=>'حمید','family'=>'احتشام','type'=>3,'subject'=>'کارشناس اداری','active'=>1,'ntcp'=>0],
            ['id'=>4,'username'=>'lashani','password'=>$password,'name'=>'سجاد','family'=>'لشنی','type'=>2,'subject'=>'کارشناس فنی','active'=>1,'ntcp'=>0],
            ['id'=>5,'username'=>'mottaghi','password'=>$password,'name'=>'مرتضی','family'=>'متقی','type'=>2,'subject'=>'کارشناس فنی','active'=>1,'ntcp'=>0],
            ['id'=>6,'username'=>'najafi','password'=>$password,'name'=>'میثم','family'=>'نجفی','type'=>3,'subject'=>'کارشناس اداری','active'=>1,'ntcp'=>0],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
