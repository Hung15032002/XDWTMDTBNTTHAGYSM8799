<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('account')->nullable();
            $table->decimal('amount', 15, 2)->nullable(); // Số tiền giao dịch
            $table->decimal('balance', 15, 2)->nullable(); // Số dư khả dụng
            $table->text('description')->nullable(); // Mô tả giao dịch
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_transactions');
    }
}
