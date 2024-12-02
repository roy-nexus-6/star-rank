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
        Schema::create('celebrity_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('celebrity_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            // 外部キー制約
            $table->foreign('celebrity_id')->references('id')->on('celebrities')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('celebrity_tag');
    }
};
