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
    Schema::create('settings', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->boolean('mention_notifiable')->default(True);
      $table->boolean('comment_notifiable')->default(True);
      $table->boolean('like_notifiable')->default(True);
      $table->boolean('follow_notifiable')->default(True);
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      // $table->json('settings');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('settings');
  }
};
