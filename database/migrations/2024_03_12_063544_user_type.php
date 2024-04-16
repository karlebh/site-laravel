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
    Schema::create('user_type', function (Blueprint $table) {
      $table->integer('user')->default(0);
      $table->integer('admin')->default(1);
      $table->integer('super_admin')->default(2);
      $table->integer('site_owner')->default(10);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('admin_type');
  }
};
