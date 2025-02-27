<?php

namespace Database\Seeders;

use App\Models\OrderTracking;
use Illuminate\Database\Seeder;

class OrderTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $status = 'pending';
            $fileName = null;

            if ($i <= 5) {
                $status = 'completed';
                $fileName = 'desain_1.jpg';
            } elseif ($i == 6) {
                $status = 'in_progress';
                $fileName = 'desain_1.jpg';
            }

            OrderTracking::create([
                'id_order' => 1,
                'id_tracking_step' => $i,
                'file_name' => $fileName,
                'status' => $status
            ]);
        }
    }
}
