<?php

namespace App\Repositories\Eloquent;

use App\Job as JobModel;
use App\Repositories\ResourceRepository;
use App\Repositories\Contracts\Job as JobContract;

class Job extends ResourceRepository implements JobContract
{

  public function entity()
  {
    return JobModel::class;
  }

  public function validationRules(): array
  {
    return [
      'title' => 'required|max:255',
      'description' => 'required',
      'location' => 'required|min:1'
    ];
  }  

}