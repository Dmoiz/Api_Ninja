<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecruitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [Str::random(6), Str::random(4)];
        foreach ($names as $name) {
            DB::table('recruits')->insert([
                'name' => $name, 
                'skills' => $name,
                'status' => 'activo'
            ]);
        }
    }
}
