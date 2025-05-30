<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\VPS;
use App\Models\Billing;
use App\Models\Notification;
use App\Notifications\VPSSuspendedNotification;
use App\Notifications\LowBalanceNotification;
use Carbon\Carbon;

class ProcessBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Proses billing VPS per jam';

    /**
     * Execute the console command.
     */
    public function handle() {
        $this->info('Memulai proses billing...');
          Log::info('Memulai proses billing...');

        // Ambil semua VPS yang aktif
        $vpsList = VPS::where('status', 'active')->get();

        foreach ($vpsList as $vps) {
            $user = $vps->user;

            // Hitung biaya per jam VPS ini
            $cost = ($vps->cpu * 100) + ($vps->ram / 1024 * 200) + ($vps->storage * 10);

            // Kurangi saldo user
            $user->balance -= $cost;
            $user->save();

            // Simpan tagihan
            Billing::create([
                'vps_id' => $vps->id,
                'hour' => now()->hour, // Menggunakan format waktu
                'cost' => $cost,
            ]);

            // Hitung total billing bulan ini
            $startOfMonth = Carbon::now()->startOfMonth();
            $totalBilling = Billing::where('vps_id', $vps->id)
                ->where('created_at', '>=', $startOfMonth)
                ->sum('cost');

            // Jika saldo < 10% dari total biaya layanan bulan ini
            if ($user->balance > 0 && $user->balance < ($totalBilling * 0.1)) {
                // Cek apakah sudah ada notifikasi hari ini untuk menghindari spam
                $today = Carbon::now()->startOfDay();
                $existingNotification = $user->notifications()
                    ->where('type', \App\Notifications\LowBalanceNotification::class)
                    ->where('created_at', '>=', $today)
                    ->exists();

                if (!$existingNotification) {
                     $user->notify(new LowBalanceNotification());
                    Log::info("Notifikasi low balance untuk user {$user->id} telah dibuat.");
                }
            }

            // Jika saldo negatif, suspend VPS
            if ($user->balance < 0) {
                $vps->status = 'suspended';
                $vps->save();

                $user->notify(new VpsSuspendedNotification());

                Log::info("VPS ID {$vps->id} untuk user {$user->id} telah di-suspend dan notifikasi dikirim.");
            }
        }

        $this->info('Billing selesai diproses.');
        Log::info('Billing selesai diproses.');
    }
}
