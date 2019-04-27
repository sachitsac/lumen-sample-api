<?php

namespace App\Repositories\Eloquent;

use App\User as UserModel;
use App\Repositories\ResourceRepository;
use App\Repositories\Contracts\User as UserContract;

class User extends ResourceRepository implements UserContract
{

  public function entity()
  {
    return UserModel::class;
  }

  protected function validationRules()
  {
    return [
      'email'     => 'required|email',
      'password'  => 'required'
    ];
  }
}
