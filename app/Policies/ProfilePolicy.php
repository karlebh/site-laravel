<?php

namespace App\Policies;

use App\Models\User;

class ProfilePolicy
{

  public function store(User $user)
  {
    return $user;
  }
}
