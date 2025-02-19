<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User 1',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password123'),
            'id_role' => 1,
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Admin User 2',
            'email' => 'admin2@mail.com',
            'password' => Hash::make('password123'),
            'id_role' => 1,
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Buyer User 1',
            'email' => 'buyer@mail.com',
            'password' => Hash::make('password123'),
            'id_role' => 2,
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Buyer User 2',
            'email' => 'buyer2@mail.com',
            'password' => Hash::make('password123'),
            'id_role' => 2,
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10),
        ]);

        User::factory(6)->create([
            'id_role' => 2,
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
