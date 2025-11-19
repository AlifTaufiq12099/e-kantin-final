<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['user','menu','lapak'])->orderBy('transaksi_id','desc')->paginate(30);
        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function show($id)
    {
        $t = Transaksi::with(['user','menu','lapak'])->findOrFail($id);
        return view('admin.transaksi.show', compact('t'));
    }

    public function updateStatus(Request $request, $id)
    {
        $t = Transaksi::findOrFail($id);
        $data = $request->validate(['status_transaksi' => 'required|in:diproses,selesai,dibatalkan,menunggu_konfirmasi']);
        $t->status_transaksi = $data['status_transaksi'];
        $t->save();
        return redirect()->back()->with('success','Status transaksi diperbarui oleh admin');
    }
}
