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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('celebrity_id')->constrained()->onDelete('cascade'); // celebrities テーブルの外部キー
            $table->string('ip_address'); // 投票者のIPアドレス
            $table->enum('vote_type', ['like', 'dislike']); // 投票タイプ: 好き or 嫌い
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
