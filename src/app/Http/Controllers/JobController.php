<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\Job as JobContract;
use Illuminate\Http\Request;
use App\Repositories\Criteria\ByUser;
use Auth;
use App\Repositories\Criteria\EagerLoad;

class JobController extends Controller
{
  
  protected $jobRepository;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(JobContract $jobRepository)
  {
    $this->jobRepository = $jobRepository;
  }

  public function index(Request $request)
  {
    return response()->json($this->jobRepository->all());
  }

  public function show($id)
  {
    return response()->json($this->jobRepository->find($id));
  }

  public function store(Request $request)
  {
    $params = $request->only(['title', 'description', 'location']);
    $params['user_id'] = $request->auth->id;
    return response()->json($this->jobRepository->create($params), 201);
  }

  public function update($id, Request $request)
  {
    $params = $request->only(['title', 'description', 'location']);
    return response()->json($this->jobRepository->update($id, $params));
  }

  public function destroy(int $id)
  {
    return response()->json($this->jobRepository->destroy($id));
  }
}
