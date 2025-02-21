<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('category')->insert([
            ['name_category' => 'Category A'],
            ['name_category' => 'Category B'],
            ['name_category' => 'Category C'],
            ['name_category' => 'Category D'],
        ]);
    }
}
