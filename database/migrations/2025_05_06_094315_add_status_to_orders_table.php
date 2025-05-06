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
    Schema::table('orders', function (Blueprint $table) {
        if (!Schema::hasColumn('orders', 'status')) {
            $table->enum('status', ['chua_xac_nhan', 'da_xac_nhan', 'dang_van_chuyen', 'hoan_thanh'])
                ->default('chua_xac_nhan');
        }
    });
}
    
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
    
};
