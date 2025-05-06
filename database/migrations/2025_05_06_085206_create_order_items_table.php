<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Quan hệ với bảng orders
        $table->string('name');
        $table->integer('quantity');
        $table->decimal('price', 15, 2); // Giá sản phẩm
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
