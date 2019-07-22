<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TallasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tallas')->insert([
            'name' => str_random(4),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
