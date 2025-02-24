<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('article')->insert([
            'id' => 1,
            'file_name'  => 'desain_1.jpg',
            'title'  => 'Cara Mengubah Profesi Tukang Kayu Menjadi Presiden',
            'desc'  => 'Tukang kayu merupakan sebuah profesi dibidang kerajinan tangan, sedangkan Presiden merupakan profesi untuk memimpin negara',
            'status'  => 'Yes',
            'start_Date'  => Carbon::now(),
            'end_Date'  => Carbon::now()->addMonth(),
        ]);
    }
}
