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
        Schema::create('phone_images', function (Blueprint $table) {
            $table->id();


            $table->foreignId('phone_id')
                ->constrained('phones')
                ->onDelete('cascade');
            $table->string('image_path');

            $table->timestamps();
            $table->softDeletes();

            // Nếu có bảng phones thì bật FK cho đàng hoàng
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_images');
    }
};
