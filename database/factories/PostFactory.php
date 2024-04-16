<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;
use App\Models\Setting;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $title = fake()->sentence(10);

    return [
      'user_id' => User::factory()->has(Setting::factory()),
      'category_id' => Category::factory(),
      'slug' => $title,
      'title' => $title,
      'body' => fake()->paragraph(),
    ];
  }
}
