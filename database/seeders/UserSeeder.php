<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
        'name' => 'Andi',
        'email' => 'andi@example.com',
        'password' => Hash::make('password'),
        'balance' => 500000,
        ]);

        User::factory()->create([
        'name' => 'Budi',
        'email' => 'budi@example.com',
        'password' => Hash::make('password'),
        'balance' => 1000000, 
        ]);
    }
}
