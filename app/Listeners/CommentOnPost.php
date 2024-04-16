<?php

namespace App\Listeners;

use App\Notifications\CommentedOnPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class CommentOnPost
{
  /**
   * Create the event listener.
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   */
  public function handle(object $event): void
  {
    // dd($event->model);
    $postOwner = $event->model->post->user;

    Notification::send($postOwner, new CommentedOnPost(
      postOwner: $postOwner,
      commentOwner: $event->model->user,
    ));
  }
}
