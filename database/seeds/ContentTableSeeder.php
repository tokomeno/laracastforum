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

        $th = factory('App\Thread', 8)->create()
        ->each(function($u){
        	factory('App\Reply', 3)->create([
        		'thread_id' => $u->id
        	]);
        });
    }
}
