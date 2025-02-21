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
        $faker = Faker::create();

        for ($i = 1; $i <= 3; $i++) {
            DB::table('file')->insert([
                'id_katalog' => $i,
                'file_name' => $faker->boolean(70) ? 'desain_' . $i . '.jpg' : null // 70% ada file, 30% kosong
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            DB::table('file')->insert([
                'id_katalog' => $i,
                'file_name' => $faker->boolean(70) ? 'desain_' . $i . '.jpg' : null // 70% ada file, 30% kosong
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            DB::table('file')->insert([
                'id_katalog' => $i,
                'file_name' => $faker->boolean(70) ? 'desain_' . $i . '.jpg' : null // 70% ada file, 30% kosong
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            DB::table('file')->insert([
                'id_katalog' => $i,
                'file_name' => $faker->boolean(70) ? 'desain_' . $i . '.jpg' : null // 70% ada file, 30% kosong
            ]);
        }
    }
}
