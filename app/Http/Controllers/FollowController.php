<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\UserFollowed;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserUnfollowed;

class FollowController extends Controller
{
  public function store(User $user)
  {
    auth()->user()->follows()->toggle($user);
    //when the user is unfollowed, remove the previous follow notification

    $notification = $user->notifications()->where([
      'type' => 'App\Notifications\UserFollowed',
      'notifiable_id' => $user->id
    ])->exists();

    //if user has been unfollowed but the notification still exists
    //delete it, to avoid multiple follow notifications in case of future refollow
    if (!auth()->user()->follows->contains($user) && $notification) {
      $user->notifications()->where([
        'type' => 'App\Notifications\UserFollowed',
        'notifiable_id' => $user->id
      ])->delete();
    }

    if (
      $this->currentUserIsAFollower($user)
      && $this->checkIfUserCanRecieveFollowNotifications($user)
    ) {
      Notification::send(
        $user,
        new UserFollowed(
          follower: auth()->user(),
        )
      );
    }


    // if (!$this->currentUserIsAFollower($user)) {
    //   Notification::send(
    //     $user,
    //     new UserUnfollowed(
    //       follower: auth()->user(),
    //     )
    //   );
    // }
  }

  private function checkIfUserCanRecieveFollowNotifications($user)
  {
    return $user?->setting?->follow_notifiable;
  }

  private function currentUserIsAFollower($user)
  {
    return  auth()->user()->follows()->where('id', $user->id)->exists();
  }
}
