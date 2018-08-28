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

         $th = factory('App\Thread', 10)->create(['replies_count' => 10])
        ->each(function($u){
            factory('App\Reply', 10)->create([
                'thread_id' => $u->id
            ]);
        });

         factory('App\Thread', 5)->create();

    }
}
