<?php

namespace Database\Factories;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $bool = [true, false];
    return [
      'mention_notifiable' => array_rand($bool),
      'follow_notifiable' => array_rand($bool),
      'like_notifiable' => array_rand($bool),
      'comment_notifiable' => array_rand($bool),
    ];
  }
}
