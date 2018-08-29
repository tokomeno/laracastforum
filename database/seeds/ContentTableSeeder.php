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

<<<<<<< HEAD
        $th = factory('App\Thread', 8)->create()
        ->each(function($u){
        	factory('App\Reply', 3)->create([
        		'thread_id' => $u->id
        	]);
=======
         $th = factory('App\Thread', 10)->create(['replies_count' => 10])
        ->each(function($u){
            factory('App\Reply', 10)->create([
                'thread_id' => $u->id
            ]);
>>>>>>> 0e13677933c5e972bae553f80ebc7ca56e929ce0
        });

         factory('App\Thread', 5)->create();

    }
}
