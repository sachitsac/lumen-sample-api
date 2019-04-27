<?php

namespace App\Repositories\Contracts;

interface User
{
  public function findByToken(string $token);
}
