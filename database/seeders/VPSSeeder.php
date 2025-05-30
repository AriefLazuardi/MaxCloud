<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\VPS;

class VPSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            VPS::create([
                'user_id' => $user->id,
                'cpu' => 2,
                'ram' => 4096,     
                'storage' => 50,  
                'status' => 'active',
            ]);

            VPS::create([
                'user_id' => $user->id,
                'cpu' => 4,
                'ram' => 8192,    
                'storage' => 100,  
                'status' => 'active',
            ]);
        }
    }
}
