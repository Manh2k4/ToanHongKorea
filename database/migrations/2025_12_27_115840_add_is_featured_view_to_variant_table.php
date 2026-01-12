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
        Schema::table('variants', function (Blueprint $table) {
        $table->unsignedInteger('view')->default(0); 

        // Thêm trường is_featured: mặc định là false (0), đặt sau trường view
        $table->boolean('is_featured')->default(false)->after('view');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('variants', function (Blueprint $table) {
               $table->dropColumn(['view', 'is_featured']);
        });
    }
};
