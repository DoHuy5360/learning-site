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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('creator')->nullable();
            $table->integer('from');
            $table->string('of')->nullable();
            $table->string('tag_one')->nullable();
            $table->string('tag_two')->nullable();
            $table->string('tag_three')->nullable();
            $table->string('tag_four')->nullable();
            $table->string('tag_five')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
};
