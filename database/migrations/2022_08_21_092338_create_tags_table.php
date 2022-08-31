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
            $table->string('tag_code',10);
            $table->string('name');
            $table->integer('creator');
            $table->string('type');
            $table->text('tag_description')->nullable()->default("Thẻ này chưa được cập nhật thông tin, nhằm đảm bảo tính chính xác, trường thông tin này chỉ được cập nhật bởi người quản trị (Admin).");
            $table->text('tag_avatar')->nullable();
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
