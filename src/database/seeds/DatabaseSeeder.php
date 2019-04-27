<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default user
        factory(App\User::class, 1)->create(['email' => 'user@example.com'])->each(function ($user) {
            factory(App\Job::class, rand(2, 10))->create(['user_id' => $user->id]);
        });

        factory(App\User::class, 10)->create()->each(function($user) {
            factory(App\Job::class, rand(2, 10))->create(['user_id' => $user->id]);
        });
    }
}
