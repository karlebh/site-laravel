<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
  protected static ?string $password;

  public function definition(): array
  {
    $name = str()->slug(fake()->name());
    return [
      'name' => $name,
      'is_admin' => false,
      'admin_type' => 0,
      'email' => fake()->unique()->safeEmail(),
      'email_verified_at' => now(),
      'password' => static::$password ??= Hash::make('password'),
      'remember_token' => Str::random(10),
    ];
  }

  public function admin(): static
  {
    return $this->state(fn (array $attributes) => [
      'is_admin' => true,
      'admin_type' => 1,
    ]);
  }

  public function unverified(): static
  {
    return $this->state(fn (array $attributes) => [
      'email_verified_at' => null,
    ]);
  }
}
