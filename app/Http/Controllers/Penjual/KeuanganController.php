<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keuangan;

class KeuanganController extends Controller
{
    public function index()
    {
        $penjual = Auth::guard('penjual')->user();
        $items = Keuangan::where('lapak_id', $penjual->lapak_id)->orderBy('keuangan_id','desc')->paginate(20);
        return view('penjual.keuangan.index', compact('items'));
    }

    public function create()
    {
        return view('penjual.keuangan.create');
    }

    public function store(Request $request)
    {
        $penjual = Auth::guard('penjual')->user();
        $data = $request->validate([
            'tanggal'=>'nullable|date',
            'jenis_transaksi'=>'nullable|string',
            'jumlah_uang'=>'required|numeric',
            'keterangan'=>'nullable|string'
        ]);

        $data['lapak_id'] = $penjual->lapak_id;
        Keuangan::create($data);
        return redirect()->route('penjual.keuangan.index')->with('success','Data keuangan dibuat');
    }

    public function edit($id)
    {
        $penjual = Auth::guard('penjual')->user();
        $item = Keuangan::where('lapak_id', $penjual->lapak_id)->where('keuangan_id', $id)->firstOrFail();
        return view('penjual.keuangan.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $penjual = Auth::guard('penjual')->user();
        $item = Keuangan::where('lapak_id', $penjual->lapak_id)->where('keuangan_id', $id)->firstOrFail();
        $data = $request->validate([
            'tanggal'=>'nullable|date',
            'jenis_transaksi'=>'nullable|string',
            'jumlah_uang'=>'required|numeric',
            'keterangan'=>'nullable|string'
        ]);

        $item->update($data);
        return redirect()->route('penjual.keuangan.index')->with('success','Data keuangan diupdate');
    }

    public function destroy($id)
    {
        $penjual = Auth::guard('penjual')->user();
        $item = Keuangan::where('lapak_id', $penjual->lapak_id)->where('keuangan_id', $id)->firstOrFail();
        $item->delete();
        return redirect()->route('penjual.keuangan.index')->with('success','Data keuangan dihapus');
    }
}
