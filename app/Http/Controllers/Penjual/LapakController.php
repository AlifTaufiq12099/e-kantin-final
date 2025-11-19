<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lapak;
use App\Models\LapakLog;
use Illuminate\Support\Facades\Auth;
use App\Models\Penjual;

class LapakController extends Controller
{
    public function edit()
    {
        $penjual = Auth::guard('penjual')->user();
        // if penjual has a lapak_id, try to load it; otherwise prepare empty lapak for creation
        $lapak = null;
        if ($penjual->lapak_id) {
            $lapak = Lapak::find($penjual->lapak_id);
        }

        return view('penjual.lapaks.edit', compact('lapak'));
    }

    public function update(Request $request)
    {
        $penjual = Auth::guard('penjual')->user();
        $lapak = null;
        if ($penjual->lapak_id) {
            $lapak = Lapak::find($penjual->lapak_id);
        }

        $data = $request->validate([
            'nama_lapak' => 'required|string',
            'pemilik' => 'nullable|string',
            'no_hp_pemilik' => 'nullable|string'
        ]);

        // If lapak doesn't exist yet, create it, otherwise update and log changes
        if (! $lapak) {
            $lapak = Lapak::create([
                'nama_lapak' => $data['nama_lapak'],
                'pemilik' => $data['pemilik'] ?? $penjual->nama_penjual,
                'no_hp_pemilik' => $data['no_hp_pemilik'] ?? null,
            ]);

            // link lapak to penjual
            $penjual->lapak_id = $lapak->lapak_id;
            $penjual->save();

            LapakLog::create([
                'lapak_id' => $lapak->lapak_id,
                'changed_by' => $penjual->penjual_id,
                'changed_by_role' => 'penjual',
                'old_data' => null,
                'new_data' => $data,
            ]);

            return redirect()->route('penjual.dashboard')->with('success', 'Lapak dibuat dan ditautkan ke akun Anda');
        }

        // Record old and new for log
        $old = [
            'nama_lapak' => $lapak->nama_lapak,
            'pemilik' => $lapak->pemilik,
            'no_hp_pemilik' => $lapak->no_hp_pemilik,
        ];

        $lapak->update($data);

        $new = [
            'nama_lapak' => $lapak->nama_lapak,
            'pemilik' => $lapak->pemilik,
            'no_hp_pemilik' => $lapak->no_hp_pemilik,
        ];

        LapakLog::create([
            'lapak_id' => $lapak->lapak_id,
            'changed_by' => $penjual->penjual_id,
            'changed_by_role' => 'penjual',
            'old_data' => $old,
            'new_data' => $new,
        ]);

        return redirect()->route('penjual.dashboard')->with('success', 'Lapak diperbarui');
    }
}
