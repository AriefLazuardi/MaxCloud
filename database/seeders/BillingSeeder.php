<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VPS;
use App\Models\Billing;
use Illuminate\Support\Carbon;

class BillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vpsList = VPS::all();

        foreach ($vpsList as $vps) {
            for ($i = 1; $i <= 5; $i++) {
                Billing::create([
                    'vps_id' => $vps->id,
                    'hour' => $i,
                    'cost' => 10000,
                    'created_at' => now()->subHours($i),
                    'updated_at' => now()->subHours($i),
                ]);
            }
        }
    }
}
