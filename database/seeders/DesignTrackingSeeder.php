<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DesignTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trackingSteps = DB::table('tracking_step_design')->orderBy('step_order')->pluck('id')->toArray();
        $designIds = DB::table('custom_design')->pluck('id')->toArray();

        $data = [];

        foreach ($designIds as $designIndex => $designId) {
            // Tentukan sejauh mana desain ini sudah selesai (acak tetapi tetap berurutan)
            $completedSteps = rand(1, count($trackingSteps)); // Minimal step 1, maksimal semua selesai

            foreach ($trackingSteps as $index => $stepId) {
                if ($index + 1 < $completedSteps) {
                    $status = 'completed';
                    $completedAt = Carbon::now()->subDays(10 - $index);
                    $fileName = "design_step_{$stepId}.png";
                    $notes = "Step completed successfully";
                } elseif ($index + 1 == $completedSteps) {
                    $status = 'in_progress';
                    $completedAt = null;
                    $fileName = null;
                    $notes = null;
                } else {
                    $status = 'pending';
                    $completedAt = null;
                    $fileName = null;
                    $notes = null;
                }

                $data[] = [
                    'id_custom_design'        => $designId,
                    'id_tracking_step_design' => $stepId,
                    'status'                  => $status,
                    'notes'                   => $notes,
                    'file_name'               => $fileName,
                    'completed_at'            => $completedAt,
                    'created_at'              => Carbon::now(),
                    'updated_at'              => Carbon::now(),
                ];
            }
        }

        DB::table('design_tracking')->insert($data);
    }
}

// <?php

// namespace Database\Seeders;

// use App\Models\DesignTracking;
// use Illuminate\Database\Seeder;

// class DesignTrackingSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         for ($i = 1; $i <= 4; $i++) {
//             $status = 'pending';
//             $fileName = null;

//             if ($i <= 2) {
//                 $status = 'completed';
//                 $fileName = 'desain_custom_1.jpg';
//             } elseif ($i == 3) {
//                 $status = 'in_progress';
//                 $fileName = 'desain_custom_1.jpg';
//             }

//             DesignTracking::create([
//                 'id_custom_design' => 2,
//                 'id_tracking_step_design' => $i,
//                 'file_name' => $fileName,
//                 'status' => $status
//             ]);
//         }
//     }
// }
