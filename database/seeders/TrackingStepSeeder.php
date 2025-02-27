<?php

namespace Database\Seeders;

use App\Models\TrackingStep;
use Illuminate\Database\Seeder;

class TrackingStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = [
            ['step_name' => 'Compurized Moulding', 'step_order' => 1],
            ['step_name' => 'Materials Procurement', 'step_order' => 2],
            ['step_name' => 'Component Processing', 'step_order' => 3],
            ['step_name' => 'Assembling', 'step_order' => 4],
            ['step_name' => 'Detailing', 'step_order' => 5],
            ['step_name' => 'Finishing', 'step_order' => 6],
            ['step_name' => 'Final Check', 'step_order' => 7],
            ['step_name' => 'Packaging', 'step_order' => 8],
            ['step_name' => 'Shipping', 'step_order' => 9],
            ['step_name' => 'Documentation', 'step_order' => 10]
        ];

        foreach ($steps as $step) {
            TrackingStep::create($step);
        }
    }
}
