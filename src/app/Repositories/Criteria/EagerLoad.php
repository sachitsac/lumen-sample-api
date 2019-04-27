<?php

namespace App\Repositories\Criteria;

use App\Repositories\Criteria\ICriteria;

class EagerLoad implements ICriteria
{
  protected $relations;

  public function __construct(array $relations)
  {
    $this->relations = $relations;
  }

  public function apply($entity)
  {
    return $entity->with($this->relations);
  }
}
