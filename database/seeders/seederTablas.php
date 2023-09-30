<?php

namespace Database\Seeders;


use Carbon\Carbon;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class seederTablas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sedes')->insert([
            'nombre' => 'Guadalajara, Jalisco',
            //'created_at' => Carbon::now(),
            //'updated_at' => Carbon::now(),
        ]);

        DB::table('sedes')->insert([
            'nombre' => 'Ciudad de México, México.',
            //'created_at' => Carbon::now(),
            //'updated_at' => Carbon::now(),
        ]);

        DB::table('sedes')->insert([
            'nombre' => 'Monterrey, Nuevo León.',
            //'created_at' => Carbon::now(),
            //'updated_at' => Carbon::now(),
        ]);
    }
}
