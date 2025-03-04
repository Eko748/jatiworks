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
        $desc = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

        Katalog::create([
            'item_name' => 'Park Bench',
            'code' => 'CDA001',
            'material' => 'Jati Wood',
            'length' => 10,
            'width' => 4,
            'height' => 2,
            'weight' => 6,
            'desc' => $desc,
        ]);

        Katalog::create([
            'item_name' => 'Dining Table',
            'code' => 'PAX001',
            'material' => 'Common Wood',
            'length' => 8,
            'width' => 3,
            'height' => 1,
            'weight' => 3,
            'desc' => $desc,
        ]);

        Katalog::create([
            'item_name' => 'AK47',
            'code' => 'CCO001',
            'material' => 'Uranium',
            'length' => 9.5,
            'width' => 5,
            'height' => 2.5,
            'weight' => 4,
            'desc' => $desc,
        ]);

        Katalog::create([
            'item_name' => 'Furina Furina Furina Furina Furina Furina',
            'code' => 'GI02X',
            'material' => 'Furina, Furina, Mavuika',
            'length' => 7.5,
            'width' => 7,
            'height' => 2.5,
            'weight' => 7,
            'desc' => $desc,
        ]);
    }
}
