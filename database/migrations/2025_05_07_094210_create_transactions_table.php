<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('account_number');        // Số tài khoản
            $table->dateTime('transaction_date');    // Ngày giao dịch
            $table->string('amount');                // Số tiền (dạng chuỗi vì có thể có "đ")
            $table->string('balance');               // Số dư
            $table->string('description');           // Nội dung chuyển khoản
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
