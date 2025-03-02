<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomDesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['WP', 'NC', 'PC']; // Status dari OrderStatus Enum
        $designs = [];

        for ($i = 1; $i <= 10; $i++) {
            $designs[] = [
                'id'          => $i,
                'item_name'   => "Custom Design $i",
                'code_design' => str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'id_user'     => rand(1, 5),
                'price'       => rand(1000, 5000),
                'status'      => $statuses[array_rand($statuses)],
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ];
        }

        DB::table('custom_design')->insert($designs);
    }
}
