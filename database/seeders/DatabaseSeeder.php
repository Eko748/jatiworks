<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            KatalogSeeder::class,
            FileSeeder::class,
            CategorySeeder::class,
            PostCategorySeeder::class,
            ArticleSeeder::class,
            OrderSeeder::class,
            TrackingStepSeeder::class,
            OrderTrackingSeeder::class,
            TrackingStepDesignSeeder::class,
        ]);
    }
}
