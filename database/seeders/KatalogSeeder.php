<?php

namespace Database\Seeders;

use App\Models\Katalog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Katalog::create([
            'item_name' => 'Park Bench',
            'material' => 'Jati Wood',
            'length' => 10,
            'width' => 4,
            'height' => 2,
            'weight' => 6,
            'desc' => 'Best Park Wood',
        ]);

        Katalog::create([
            'item_name' => 'Dining Table',
            'material' => 'Common Wood',
            'length' => 8,
            'width' => 3,
            'height' => 1,
            'weight' => 3,
            'desc' => 'Omaygoto',
        ]);

        Katalog::create([
            'item_name' => 'AK47',
            'material' => 'Uranium',
            'length' => 9.5,
            'width' => 5,
            'height' => 2.5,
            'weight' => 4,
            'desc' => 'LoremPisum',
        ]);

        Katalog::create([
            'item_name' => 'Furina Furina Furina',
            'material' => 'Furina, Furina, Mavuika',
            'length' => 7.5,
            'width' => 7,
            'height' => 2.5,
            'weight' => 7,
            'desc' => 'Anime',
        ]);
    }
}
