<?php

namespace App\Repositories\Contracts;

interface ResourceRepositoryInterface
{
  public function all();
  public function find(int $id);
  public function create(array $params);
  public function update(int $id, array $params);
  public function destroy(int $id);
}