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
    Schema::create('user_follower', function (Blueprint $table) {
      $table->unsignedBigInteger('user_id')->nullable();
      $table->unsignedBigInteger('follower_id')->nullable();

      $table->foreign('user_id')->references('id')->on('users')->nullable();
      $table->foreign('follower_id')->references('id')->on('users')->nullable();

      $table->primary(['user_id', 'follower_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('user_follower');
  }
};
