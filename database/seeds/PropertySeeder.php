<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property')->insert([
            'title' => Str::random(5),
            'description' => Str::random(15),
            'price' => '100',
            'floor_area' => '10', 
            'bedroom' => '1', 
            'bathroom' => '1',
            'city' => Str::random(5),
            'address' => Str::random(15),
            'nearby' => Str::random(5),
            'created_at' => Carbon::now(), 
        ]);
    }
}
