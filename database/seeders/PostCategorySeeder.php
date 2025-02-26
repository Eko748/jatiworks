<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('post_category')->insert([
            ['id_katalog' => 1, 'id_category' => 2],
            ['id_katalog' => 1, 'id_category' => 3],
            ['id_katalog' => 1, 'id_category' => 4],
            ['id_katalog' => 2, 'id_category' => 1],
            ['id_katalog' => 2, 'id_category' => 3],
            ['id_katalog' => 3, 'id_category' => 5],
            ['id_katalog' => 3, 'id_category' => 6],
            ['id_katalog' => 4, 'id_category' => 5],
            ['id_katalog' => 4, 'id_category' => 6],
            ['id_katalog' => 4, 'id_category' => 7],
            ['id_katalog' => 4, 'id_category' => 8],
        ]);
    }
}
