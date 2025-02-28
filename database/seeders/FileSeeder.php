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
            'file_name'  => '1740402203_200322_240225_0.png'
        ]);
        DB::table('file')->insert([
            'id_katalog' => 2,
            'file_name'  => '1740402065_200104_240225_1.png'
        ]);
        DB::table('file')->insert([
            'id_katalog' => 3,
            'file_name'  => '1740402065_200104_240225_0.png'
        ]);
        DB::table('file')->insert([
            'id_katalog' => 1,
            'file_name'  => '1740402065_200104_240225_1.png'
        ]);
        DB::table('file')->insert([
            'id_katalog' => 3,
            'file_name'  => '1740402065_200104_240225_1.png'
        ]);
        DB::table('file')->insert([
            'id_katalog' => 4,
            'file_name'  => '1740402065_200104_240225_3.png'
        ]);
        DB::table('file')->insert([
            'id_katalog' => 4,
            'file_name'  => '1740402065_200104_240225_4.png'
        ]);
        DB::table('file')->insert([
            'id_katalog' => 4,
            'file_name'  => '1740402065_200104_240225_2.png'
        ]);
        DB::table('file')->insert([
            'id_design' => 1,
            'file_name'  => '1740402065_200104_240225_2.png'
        ]);
        DB::table('file')->insert([
            'id_order' => 1,
            'file_name'  => '1740402065_200104_240225_5.png'
        ]);
    }
}
