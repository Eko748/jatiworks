<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order')->insert([
            'id' => 1,
            'id_user'  => '4',
            'code_order'  => '69696969',
            'item_name'  => 'Aquarium',
            'material'  => 'Kaca, Kayu Jati, Karet',
            'length'  => '4',
            'width'  => '2',
            'height'  => '1',
            'weight'  => '6',
            'desc'  => 'Info Mint',
            'qty'  => '4',
            'unit'  => 'm',
            'price'  => '5000000',
            'status'  => 'WP',
        ]);

        DB::table('order')->insert([
            'id' => 2,
            'code_order' => '28325825',
            'id_user'  => '6',
            'id_katalog' => '3',
            'qty' => '8',
            'price' => '15000000',
            'status' => 'NC',
        ]);
    }
}
