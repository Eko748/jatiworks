<?php

namespace Database\Seeders;

use App\Models\Po;
use App\Models\User;
use Illuminate\Database\Seeder;

class PoSeeder extends Seeder
{
    public function run(): void
    {
            Po::create([
                'id_user' => 5,
                'kode_po' => 'PO32523',
                'dp' => 200000,
                'file' => 'tesSeeder',
                'desc' => 'BarangKali',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}