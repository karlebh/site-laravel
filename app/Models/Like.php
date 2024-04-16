<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
  use HasFactory;

  protected $casts = [
    'liked' => 'boolean'
  ];

  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function likeable()
  {
    return $this->morphTo();
  }
}
