<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('phones', function (Blueprint $table) {
            // Thêm cột view sau cột main_image (hoặc cột nào bạn muốn)
            $table->unsignedInteger('view')->default(0)->after('main_image');

            // Thêm cột is_featured sau cột view
            $table->boolean('is_featured')->default(false)->after('view');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phones', function (Blueprint $table) {
            // Xóa các cột nếu rollback migration
            $table->dropColumn(['view', 'is_featured']);
        });
    }
};
