<?php

use Illuminate\Database\Seeder;

class ContentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => bcrypt('password')
        ]);

         \App\User::create([
            'name' => 'toka',
            'email' => 'tokamenabde@gmail.com',
            'password' => bcrypt('password')
        ]);

         $th = factory('App\Thread', 10)->create()
        ->each(function($u){
            factory('App\Reply', 10)->create([
                'thread_id' => $u->id
            ]);
        });

         factory('App\Thread', 5)->create();

    }
}
