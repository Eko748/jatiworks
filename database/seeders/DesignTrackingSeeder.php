<?php

namespace Database\Seeders;

use App\Models\DesignTracking;
use Illuminate\Database\Seeder;

class DesignTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 4; $i++) {
            $status = 'pending';
            $fileName = null;

            if ($i <= 2) {
                $status = 'completed';
                $fileName = 'desain_custom_1.jpg';
            } elseif ($i == 3) {
                $status = 'in_progress';
                $fileName = 'desain_custom_1.jpg';
            }

            DesignTracking::create([
                'id_custom_design' => 2,
                'id_tracking_step_design' => $i,
                'file_name' => $fileName,
                'status' => $status
            ]);
        }
    }
}
