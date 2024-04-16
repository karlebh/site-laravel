<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends Model
{
  use HasFactory, Searchable;

  protected $guarded = [];

  public function getRouteKeyName(): string
  {
    return 'slug';
  }

  public function slug(): Attribute
  {
    return Attribute::make(
      set: fn (string $value) => $this->sluggify($value)
    );
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  protected function firstName(): Attribute
  {
    return Attribute::make(
      get: fn (string $value) => ucfirst($value),
      set: fn (string $value) => strtolower($value),
    );
  }

  private function sluggify($title)
  {
    $randInt =  rand(1000, 5000);

    return strtolower(
      str_replace(' ', '-', $title)
    ) . "-{$randInt}";
  }
}
