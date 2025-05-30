<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VPS;
use App\Models\Billing;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VPSController extends Controller
{
    // GET /api/vps - List VPS milik user
    public function index()
    {
        $vps = VPS::where('user_id', Auth::id())->get();
        return response()->json($vps);
    }

    // POST /api/vps - Buat VPS baru
    public function store(Request $request)
    {
        $request->validate([
            'cpu' => 'required|integer|min:1',
            'ram' => 'required|integer|min:512',
            'storage' => 'required|integer|min:10',
        ]);

        $user = Auth::user();

        // Hitung biaya per jam
        $costPerHour = ($request->cpu * 100) + ($request->ram / 1024 * 200) + ($request->storage * 10);
        
        // Minimal saldo untuk 1 bulan operasi (30 hari * 24 jam)
        // Sesuai dengan logika requirement #6 yang menggunakan persentase bulanan
        $minimumBalance = $costPerHour * 24 * 30;

        if ($user->balance < $minimumBalance) {
           return response()->json([
                'status' => 'error',
                'message' => 'Saldo tidak cukup untuk membuat VPS',
                'data' => [
                    'required_balance' => $minimumBalance,
                    'current_balance' => $user->balance,
                    'cost_per_hour' => $costPerHour,
                ],
            ], 400);
        }

        // Buat VPS
        $vps = VPS::create([
            'user_id' => $user->id,
            'cpu' => $request->cpu,
            'ram' => $request->ram,
            'storage' => $request->storage,
            'status' => 'active',
            'created_at' => Carbon::now(),
        ]);

        // Buat record billing pertama (billing dimulai tepat setelah VPS dibuat)
        Billing::create([
            'user_id' => $user->id,
            'vps_id' => $vps->id,
            'cost' => $costPerHour, // Simpan biaya per jam untuk referensi
            'hour' => now()->hour,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'VPS berhasil dibuat',
            'data' => [
                'vps' => $vps,
                'cost_per_hour' => $costPerHour,
                'billing_started' => true,
            ],
        ], 201);
    }

    // GET /api/vps/{id} - Detail VPS
    public function show($id)
    {
        $vps = VPS::where('id', $id)->where('user_id', Auth::id())->first();

        if (! $vps) {
            return response()->json(['message' => 'VPS tidak ditemukan'], 404);
        }

        return response()->json($vps);
    }

    // DELETE /api/vps/{id} - Hapus VPS
    public function destroy($id)
    {
        $vps = VPS::where('id', $id)->where('user_id', Auth::id())->first();

        if (! $vps) {
            return response()->json(['message' => 'VPS tidak ditemukan'], 404);
        }

        $vps->delete();

        return response()->json(['message' => 'VPS berhasil dihapus']);
    }
}
