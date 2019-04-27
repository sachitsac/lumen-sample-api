<?php

namespace App\Repositories\Criteria;

use App\Repositories\Criteria\ICriteria;

class ByUser implements ICriteria
{
  protected $userId;

  public function __construct($userId)
  {
    $this->userId = $userId;
  }

  public function apply($entity)
  {
    return $entity->where('user_id', $this->userId);
  }
}

