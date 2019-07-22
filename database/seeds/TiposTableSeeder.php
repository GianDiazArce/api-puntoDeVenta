<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos')->insert([
            'name' => str_random(7),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
