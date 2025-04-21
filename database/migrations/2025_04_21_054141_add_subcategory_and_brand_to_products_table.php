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
        Schema::table('products', function (Blueprint $table) {
            // Thêm cột khóa ngoại liên kết với bảng subcategories
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->onDelete('set null');
            
            // Thêm cột khóa ngoại liên kết với bảng brands
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Xóa các khóa ngoại nếu có
            $table->dropForeign(['subcategory_id']);
            $table->dropColumn('subcategory_id');
            
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
        });
    }
};
