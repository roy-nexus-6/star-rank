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
        Schema::create('celebrity_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('celebrity_id')->constrained()->onDelete('cascade'); // celebritiesテーブルへの外部キー
            $table->string('image_path'); // Google Drive画像のパス
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('celebrity_images');
    }
};
