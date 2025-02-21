<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('file')->insert([
            'id_katalog' => 1,
            'file_name'  => 'desain_1.jpg'
        ]);
        DB::table('file')->insert([
            'id_katalog' => 2,
            'file_name'  => 'desain_1.jpg'
        ]);
        DB::table('file')->insert([
            'id_katalog' => 3,
            'file_name'  => 'desain_1.jpg'
        ]);
        DB::table('file')->insert([
            'id_katalog' => 1,
            'file_name'  => 'desain_1.jpg'
        ]);
        DB::table('file')->insert([
            'id_katalog' => 1,
            'file_name'  => 'desain_1.jpg'
        ]);
    }
}
