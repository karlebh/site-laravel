<?php

namespace App\Models;

use App\Notifications\UserMentioned;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

use function PHPUnit\Framework\matches;

class Post extends Model
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

  public function comments(): HasMany
  {
    return $this->hasMany(Comment::class)->whereNull('parent_id');
  }

  public function images(): MorphMany
  {
    return $this->morphMany(Image::class, 'imageable');
  }

  public function likes(): MorphMany
  {
    return $this->morphMany(Like::class, 'likeable');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo(category::class);
  }

  public function mentionedUsers()
  {
    //it is best to use '@' and/or '#' like twitter and not just
    //get all the text like on nairaland because it might be expensive to do so.

    //One second thought, there could be a way to get all the text that passes `min:4` and `max:10`
    //in RegisteredUserController and get the actual users from these them notify them to
    //mimick NL notification

    preg_match_all('/@([w+])', $this->body, $matches);
    return $matches[1];
  }

  private function sluggify($title)
  {
    $randInt =  rand(1000, 5000);

    $slug =  str()->slug($title) . "-{$randInt}";

    return $slug;
  }

  public function toSearchableArray(): array
  {
    $array = $this->toArray();

    return array_merge([
      'title' => $this->title,
      'body' => $this->body,
    ], $array);
  }

  //This method does not work as expected
  //It can't grab names like these: 01-caleb, dr-caleb-akeju
  public function mentions()
  {
    $pattern = '/[@#]?[a-zA-Z]+-[a-zA-Z]+-/';
    preg_match_all($pattern, $this->body, $matches);

    return $matches[0];
  }
}
