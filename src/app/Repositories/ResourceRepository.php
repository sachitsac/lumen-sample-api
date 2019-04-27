<?php

namespace App\Repositories;

use App\Repositories\Contracts\ResourceRepositoryInterface;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class ResourceRepository implements ResourceRepositoryInterface
{
  protected $entity;

  public function __construct()
  {
    $this->entity = $this->resolveEntity();
  }

  public function all()
  {
    return $this->entity->paginate(10);
  }

  public function find(int $id)
  {
    $model = $this->entity->find($id);
    if (!$model) {
      $modelName = $this->className();
      throw new ModelNotFoundException("${modelName} with id ${id} not found");
    }
    return $model;
  }

  public function create(array $params)
  {
    if (method_exists($this, 'validationRules')) {
      $validator = Validator::make($params, $this->validationRules());

      if ($validator->fails()) {   
        throw new \InvalidArgumentException(implode(",", $validator->messages()->all()));
      }
    }

    return $this->entity->create($params);
  }

  public function update(int $id, array $params)
  {
    if (method_exists($this, 'validationRules')) {
      $validator = Validator::make($params, $this->validationRules());

      if ($validator->fails()) {
        throw new \InvalidArgumentException(implode(",", $validator->messages()->all()));
      }
    }

    $instance = $this->entity->find($id);

    if (!$id) {
      $modelName = $this->className();
      throw new ModelNotFoundException("${modelName} with id ${id} not found");
    }

    $updated = $instance->update($params);

    if(!$updated) {
      $modelName = $this->className();
      throw new \Exception("Updating ${modelName} failed");
    }

    return $this->entity->find($id);
  }

  public function destroy(int $id)
  {
    $model =  $this->find($id);
    return $model->delete($id);
  }

  public function withCriteria(...$criteria)
  {
    $criteria = array_flatten($criteria);

    foreach ($criteria as $criterion) {
      $this->entity = $criterion->apply($this->entity);
    }

    return $this;
  }

  protected function resolveEntity()
  {
    if(!method_exists($this, 'entity')) {
      throw new \Exception('Method entity does not exist');
    }
    return app()->make($this->entity());
  }

  protected function className(): string
  {
    $path = explode('\\', get_class($this->entity));
    return (string) array_pop($path);
  }
}