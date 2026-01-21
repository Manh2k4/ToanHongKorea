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
        Schema::create('review_videos', function (Blueprint $table) {
            $table->id();
            // Liên kết với sản phẩm (Phone)
            $table->foreignId('phone_id')->constrained('phones')->onDelete('cascade');

            $table->string('title'); // Tiêu đề video
            $table->string('video_path'); // Đường dẫn file video
            $table->string('thumbnail_path')->nullable(); // Ảnh đại diện video (Poster)

            $table->integer('sort_order')->default(0); // Thứ tự hiển thị
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_videos');
    }
};
