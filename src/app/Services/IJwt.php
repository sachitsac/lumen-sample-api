<?php

namespace App\Services;

use App\User;

interface IJwt
{
  public function fromUser(User $user): string;
  public function toUser(string $token);
}