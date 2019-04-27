<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\{
  Job as JobContract
};

use App\Repositories\Eloquent\{
  Job as JobRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
  
  public function register()
  {
    //
  }
  
  public function boot()
  {
    $this->app->bind(JobContract::class, JobRepository::class);
  }
}
