<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Setting;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $name = fake()->name();

    return [
      'user_id' => User::factory()->has(Setting::factory()),
      'name' => $name,
      'slug' => $name,
      'desc' => fake()->paragraph(),
    ];
  }
}
