<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\UserMentioned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class MentionUser
{
  public function handle(object $event): void
  {
    // dd($event->model->mentions());
    //The Regular Expression that grabs the names is falty
    $users = User::has('setting')->whereIn('name', $event->model->mentions())->get();
    Notification::send($users, new UserMentioned($event->url));
  }
}
