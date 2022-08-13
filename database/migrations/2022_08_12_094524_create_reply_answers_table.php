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
        Schema::create('reply_answers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('reply_code',10);
            $table->string('reply_for',10);
            $table->integer('content_type');
            $table->integer('answer_replier');
            $table->text('content');
            $table->boolean('edited')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reply_answers');
    }
};
