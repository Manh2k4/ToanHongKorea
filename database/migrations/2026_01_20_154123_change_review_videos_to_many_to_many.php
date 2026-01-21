<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('many', function (Blueprint $table) {
            // 1. Xóa cột phone_id cũ ở bảng review_videos
            Schema::table('review_videos', function (Blueprint $table) {
                // Phải xóa khóa ngoại trước khi xóa cột
                $table->dropForeign(['phone_id']);
                $table->dropColumn('phone_id');
            });

            // 2. Tạo bảng trung gian (Pivot table) để nối Video với nhiều Phone
            Schema::create('phone_review_video', function (Blueprint $table) {
                $table->id();
                $table->foreignId('phone_id')->constrained('phones')->onDelete('cascade');
                $table->foreignId('review_video_id')->constrained('review_videos')->onDelete('cascade');
                $table->timestamps();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('many', function (Blueprint $table) {
            // Tạo lại cột cũ nếu cần rollback
            Schema::table('review_videos', function (Blueprint $table) {
                $table->foreignId('phone_id')->nullable()->constrained('phones')->onDelete('cascade');
            });

            Schema::dropIfExists('phone_review_video');
        });
    }
};
