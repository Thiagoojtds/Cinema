<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('movies')->insert([
            'name' => 'Split',
            'description' => 'Kevin, who is suffering from dissociative identity disorder and has 23 alter egos, kidnaps three teenagers. They must figure out his friendly personas before he unleashes his 24th personality.',
            'duration' => '01:57:00',
            'image' => 'https://m.media-amazon.com/images/M/MV5BZTJiNGM2NjItNDRiYy00ZjY0LTgwNTItZDBmZGRlODQ4YThkL2ltYWdlXkEyXkFqcGdeQXVyMjY5ODI4NDk@._V1_.jpg',
            'classification' => '5'
        ]);
    }
}
