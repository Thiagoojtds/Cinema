<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classifications')->insert([
            ['name' => 'Livre'],
            ['name' => '10 Anos'],
            ['name' => '12 Anos'],
            ['name' => '14 Anos'],
            ['name' => '16 Anos'],
            ['name' => '18 Anos']
        ]);
    }
}
