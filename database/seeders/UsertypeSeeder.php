<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsertypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('user_type')->updateOrInsert([
      'user' => 0,
      'admin' => 1,
      'super_admin' => 2,
      'site_owner' => 10
    ]);
  }
}
