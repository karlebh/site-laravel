<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Notifications\UserLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{

  public function store(Request $request)
  {
    $like =  Like::firstOrCreate([
      'user_id' => auth()->id(),
      'likeable_id' => $request->id,
      'likeable_type' => $request->class,
    ]);

    $owner = $request->class::findOrFail($request->id)->user;

    if ($owner->setting->like_notifiable && $owner->id !== auth()->id()) {
      Notification::send(
        $owner,
        new UserLike(
          $request->id,
          $request->class,
          $request->url
        )
      );
    }

    if ($like) {
      return ['message' => "Item liked successfully"];
    }

    return ['message' =>  "Could not like the item"];
  }

  public function destroy(Request $request)
  {
    Like::where([
      'user_id' => auth()->id(),
      'likeable_id' => $request->query('id'),
      'likeable_type' => $request->query('class'),
    ])->delete();

    $owner = $request->class::findOrFail($request->id)->user;

    DB::table('notifications')
      ->where('notifiable_id', $owner->id)
      ->where('notifiable_type', \App\Models\User::class)
      ->where('type', \App\Notifications\UserLike::class)
      ->delete();

    return ['message' => "Item unliked successfully"];
  }
}
