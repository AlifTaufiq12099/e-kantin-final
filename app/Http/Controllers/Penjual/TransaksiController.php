<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $penjual = Auth::guard('penjual')->user();
        $transaksis = Transaksi::with(['user','menu'])->where('lapak_id', $penjual->lapak_id)->orderBy('transaksi_id','desc')->paginate(30);
        return view('penjual.transaksi.index', compact('transaksis'));
    }

    public function show($id)
    {
        $penjual = Auth::guard('penjual')->user();
        $t = Transaksi::with(['user','menu'])->where('lapak_id', $penjual->lapak_id)->where('transaksi_id', $id)->firstOrFail();
        return view('penjual.transaksi.show', compact('t'));
    }

    public function updateStatus(Request $request, $id)
    {
        $penjual = Auth::guard('penjual')->user();
        $t = Transaksi::where('lapak_id', $penjual->lapak_id)->where('transaksi_id', $id)->firstOrFail();
        // allow new statuses including 'sedang_dibuat' and 'menunggu_konfirmasi'
        $data = $request->validate(['status_transaksi'=>'required|in:diproses,selesai,dibatalkan,menunggu_konfirmasi,sedang_dibuat,siap']);
        $t->status_transaksi = $data['status_transaksi'];
        $t->save();
        return redirect()->back()->with('success','Status transaksi diperbarui menjadi: ' . $t->status_transaksi);
    }
}
