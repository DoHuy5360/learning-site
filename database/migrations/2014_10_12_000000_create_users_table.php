<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->rememberToken();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('gender', 10)->nullable();
            $table->text('avatar')->default('https://firebasestorage.googleapis.com/v0/b/image-resize-5d865.appspot.com/o/Images%2FPicsArt_02-04-03.03.51.png?alt=media&token=baaae954-583d-4d9e-ad5b-5ac722777401');
            $table->text('introduce')->nullable();
            $table->string('birthday', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
