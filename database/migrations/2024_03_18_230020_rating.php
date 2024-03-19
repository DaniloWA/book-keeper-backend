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
        Schema::create('rating', function (Blueprint $table){

        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('book_id');
        $table->integer('score');

        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users');
        $table->foreign('book_id')->references('id')->on('books');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating');
    }
};
