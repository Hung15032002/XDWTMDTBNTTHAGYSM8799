<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('facebook_link')->nullable();
            $table->string('zalo_link')->nullable();
            $table->text('address')->nullable();
            $table->text('phone_numbers')->nullable(); // Có thể lưu nhiều số điện thoại dưới dạng mảng JSON
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
