<?php

namespace App\Models;

use App\Notifications\UserMentioned;
use App\Traits\ImageSetting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Notification;
use Laravel\Scout\Searchable;

class Comment extends Model
{
  use HasFactory, Searchable, ImageSetting;

  protected $guarded = [];

  public function likes(): MorphMany
  {
    return $this->morphMany(Like::class, 'likeable');
  }

  public function images(): MorphMany
  {
    return $this->morphMany(Image::class, 'imageable');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function post(): BelongsTo
  {
    return $this->belongsTo(Post::class);
  }

  public function replies(): HasMany
  {
    return $this->hasMany(Comment::class, 'parent_id');
  }

  public function mentions()
  {
    $pattern = '/[@#]?[a-zA-Z]+-[a-zA-Z]+/';
    preg_match_all($pattern, $this->body, $matches);


    return $matches[0];
  }
}
