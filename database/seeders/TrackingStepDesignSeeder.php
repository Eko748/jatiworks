<?php

namespace Database\Seeders;

use App\Models\TrackingStepDesign;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackingStepDesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = [
            ['step_name' => 'Sketch', 'step_order' => 1],
            ['step_name' => 'Design 2D', 'step_order' => 2],
            ['step_name' => 'Design 3D', 'step_order' => 3],
            ['step_name' => 'Finish', 'step_order' => 3]
        ];

        foreach ($steps as $step) {
            TrackingStepDesign::create($step);
        }
    }
}
