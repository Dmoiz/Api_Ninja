<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [Str::random(10), Str::random(15)];
        $client_id = random_int(1,4); 
        $ninjas = random_int(1,10);
        foreach ($names as $name) {
            DB::table('misions')->insert([
                'client_id' => $client_id, 
                'description' => $name,
                'number_of_ninjas' => $ninjas,
                'priority' => 'normal',
                'payment' => $name,
                'state' => 'pendiente',
                'finish_time' => ''
            ]);
        }
    }
}
