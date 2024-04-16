<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;

class PostPolicy
{
  public function update(User $user, Post $post) {
    return $user->id === $post->user_id;
  }

  public function edit(User $user, Post $post) {
    return $user->id === $post->user_id;
  }

  public function destroy(User $user, Post $post) {
    return $user->id === $post->user_id;
  }
}
