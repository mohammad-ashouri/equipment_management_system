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
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        $password = bcrypt(12345678);
        $query = "INSERT INTO `users` (`id`, `username`, `password`, `name`, `family`, type, subject, active, ntcp)
VALUES (1, 'ofullalisoft', '$password', 'ofullalisoft',
        'ofullalisoft', 1, 'Super Admin', 1, 0),
       (2, 'tabatabaii', '$password', 'tabatabaii', 'tabatabaii', 1,
        'Super Admin', 1, 0),
       (3, 'morteza', '$password', 'morteza', 'morteza', 1,
        'Super Admin', 1, 0),
       (7, 'mohammadi', '$password', 'mohammadi', 'mohammadi', 1,
        'Super Admin', 1, 0),
       (8, 'abedi', '$password', 'abedi', 'abedi', 1, 'Super Admin',
        1, 0),
       (9, 'ahmadi', '$password', 'ahmadi', 'ahmadi', 1,
        'Super Admin', 1, 0),
       (10, 'admin', '$password', 'mohammad', 'ashoori', 1,
        'Super Admin', 1, 0),
       (11, 'mottaghi', '$password', 'morteza', 'mottaghi', 1,
        'Super Admin', 1, 0),
       (12, 'bodaghi', '$password', 'ali asghar', 'bodaghi', 1,
        'Super Admin', 1, 0);";

        DB::statement($query);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
