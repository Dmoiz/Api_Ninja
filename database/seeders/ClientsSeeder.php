<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $codes = [Str::random(4), Str::random(4), Str::random(4), Str::random(4)];
        $isVip = random_int(0,1);
        foreach ($codes as $code) {
            DB::table('clients')->insert([
                'code' => $code, 
                'vip' => $isVip
            ]);
        }
    }
}
