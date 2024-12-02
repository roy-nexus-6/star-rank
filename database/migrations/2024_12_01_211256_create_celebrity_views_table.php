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
        Schema::create('celebrity_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('celebrity_id');
            $table->date('view_date'); // 閲覧の日付
            $table->unsignedBigInteger('view_count')->default(0); // 閲覧数
            $table->timestamps();

            $table->foreign('celebrity_id')->references('id')->on('celebrities')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('celebrity_views');
    }
};
