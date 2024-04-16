<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, Searchable;

  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'data' => 'array',
    'is_admin' => 'boolean',
    'admin_type' => 'integer'
  ];

  public function messages()
  {
    return $this->belongsTo(Message::class);
  }

  public function setting()
  {
    return $this->hasOne(Setting::class);
  }

  public function image()
  {
    return $this->morphOne(Image::class, 'imageable');
  }

  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  public function categories()
  {
    return $this->hasMany(Category::class);
  }

  public function likes()
  {
    return $this->hasMany(Like::class);
  }

  public function follows()
  {
    return $this->belongsToMany(User::class, "user_follower", "user_id", "follower_id");
  }

  public function isAdmin()
  {
    return ($this->is_admin && in_array($this->admin_type, [1, 2, 10]));
  }

  // #[SearchUsingPrefix(['id', 'email'])]
  // #[SearchUsingFullText(['bio'])]
  public function toSearchableArray(): array
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'email' => $this->email,
    ];
  }
}
