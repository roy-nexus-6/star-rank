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
        Schema::create('celebrity_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('celebrity_id_1'); // 関連元のセレブリティID
            $table->unsignedBigInteger('celebrity_id_2'); // 関連先のセレブリティID
            $table->timestamps();

            // 外部キー制約
            $table->foreign('celebrity_id_1')->references('id')->on('celebrities')->onDelete('cascade');
            $table->foreign('celebrity_id_2')->references('id')->on('celebrities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('celebrity_relations');
    }
};
