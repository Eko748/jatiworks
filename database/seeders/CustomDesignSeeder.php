<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomDesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('custom_design')->insert([
            'id' => 1,
            'item_name' => 'Manok Mabur',
            'code_design' => '28325825',
            'id_user'  => '5',
            'price' => '1500',
            'status' => 'WP',
        ]);
    }
}
