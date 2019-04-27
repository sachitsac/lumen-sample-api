<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\Jwt;

class JobTest extends TestCase
{
  use DatabaseTransactions;

  protected $jobStructure =[
    'id',
    'title',
    'description',
    'location',
    'created_at',
    'updated_at',
  ];

  protected $authHeader = [];

  public function setup()
  {
    parent::setup();
    $user = factory(\App\User::class, 1)->create();
    $jwt = new Jwt();
    $token = $jwt->fromUser($user[0]);
    $this->authHeader = [ 'Authorization' => "Bearer $token"];
  }

  /**
   * /api/jobs [GET]
   */
  public function testShouldReturnAllJobs()
  {
    $this->json('get', 'api/jobs', [], $this->authHeader);
    $this->seeStatusCode(200);
    $this->seeJsonStructure([
      'data' => [ '*' => $this->jobStructure ],
      'first_page_url',
      'from',
      'last_page',
      'last_page_url',
      'next_page_url',
      'path',
      'per_page',
      'prev_page_url',
      'to',
      'total'
    ]);
  }

  /**
   * /api/jobs/{id} [GET]
   */
  public function testShouldReturnJob()
  {
    $job = factory(\App\Job::class, 1)->create();
    $id = $job[0]->id;

    $this->json('get', "api/jobs/${id}", [], $this->authHeader);
    $this->seeStatusCode(200);
    $this->seeJsonStructure($this->jobStructure);
  }

  public function testShouldCreateJob()
  {
    $parameters = [
      'title' => 'Sn Software Dev',
      'description' => 'Senior Software devs are amazing. Join Us!',
      'location' => 'Melbourne',
    ];
    $this->json('post', 'api/jobs', $parameters, $this->authHeader);
    $this->seeStatusCode(201);
    $this->seeJsonStructure($this->jobStructure);
  }

  public function testShouldReturnErrorOnInvalidLocationForJob()
  {
    $parameters = [
      'title' => 'Sn Software Dev',
      'description' => 'Senior Software devs are amazing. Join Us!',
    ];

    $this->json('post', 'api/jobs', $parameters, $this->authHeader);
    $this->seeStatusCode(400);
    $this->seeJsonStructure(['error']);
  }

  public function testShouldReturnErrorOnInvalidTitleForJob()
  {
    $parameters = [
      'description' => 'Senior Software devs are amazing. Join Us!',
      'location' => 'Melbourne',
    ];

    $this->json('post', 'api/jobs', $parameters, $this->authHeader);
    $this->seeStatusCode(400);
    $this->seeJsonStructure(['error']);
  }

  public function testShouldReturnErrorOnInvalidDescriptionForJob()
  {
    $parameters = [
      'title' => 'Senior Software devs are amazing. Join Us!',
      'location' => 'Melbourne',
    ];

    $this->json('post', 'api/jobs', $parameters, $this->authHeader);
    $this->seeStatusCode(400);
    $this->seeJsonStructure(['error']);
  }

  /**
   * /api/jobs/id [PUT]
   */
  public function testShouldUpdateJob()
  {
    $job = factory(\App\Job::class, 1)->create();
    $id = $job[0]->id;

    $parameters = [
      'title' => 'Sn Software Dev',
      'description' => 'Senior Software devs are amazing. Join Us!',
      'location' => 'Melbourne',
    ];

    $this->put("api/jobs/${id}", $parameters, $this->authHeader);
    $this->seeStatusCode(200);
    $this->seeJsonStructure($this->jobStructure);;
  }

  /**
   * /api/jobs/id [PUT]
   */
  public function testShouldReturnErrorIfPartialJobProvidedForUpdate()
  {
    $job = factory(\App\Job::class, 1)->create();
    $id = $job[0]->id;

    $parameters = [
      'title' => 'Sn Software Dev',
      'description' => 'Senior Software devs are amazing. Join Us!',
    ];
    $this->put("api/jobs/${id}", $parameters, $this->authHeader);
    $this->seeStatusCode(400);
    $this->seeJsonStructure([ 'error' ]);
  }

  /**
   * /api/jobs/id [DELETE]
   */
  public function testShouldDeleteProduct()
  {
    $job = factory(\App\Job::class, 1)->create();
    $id = $job[0]->id;

    $this->delete("api/jobs/${id}", [], $this->authHeader);
    $this->seeStatusCode(200);
  }

}
