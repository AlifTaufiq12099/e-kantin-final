<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapak;
use App\Models\Menu;
use App\Models\Transaksi;

class PembeliController extends Controller
{
    // Show list of lapaks to choose
    public function selectLapak()
    {
        if (!session('logged_in') || session('role') !== 'pembeli') {
            return redirect('/login/pembeli');
        }

        $lapaks = Lapak::all();
        return view('pembeli.lapak_select', compact('lapaks'));
    }

    // Show lapak detail and menus
    public function showLapak($id)
    {
        if (!session('logged_in') || session('role') !== 'pembeli') {
            return redirect('/login/pembeli');
        }

        $lapak = Lapak::findOrFail($id);
        $menus = Menu::where('lapak_id', $lapak->lapak_id)->get();

        return view('pembeli.lapak_detail', compact('lapak','menus'));
    }

    // Store a simple order (single menu item)
    public function storeOrder(Request $request)
    {
        if (!session('logged_in') || session('role') !== 'pembeli') {
            return redirect('/login/pembeli');
        }

        $request->validate([
            'menu_id' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
            'lapak_id' => 'required|integer'
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        $jumlah = (int) $request->jumlah;
        $total = $menu->harga * $jumlah;

        $method = $request->metode_pembayaran ?? 'Tunai';
        $initialStatus = $method === 'Tunai' ? 'diproses' : 'menunggu_pembayaran';

        $transaksi = Transaksi::create([
            'user_id' => session('user_id'),
            'menu_id' => $menu->menu_id,
            'lapak_id' => $request->lapak_id,
            'waktu_transaksi' => now(),
            'jumlah' => $jumlah,
            'total_harga' => $total,
            'metode_pembayaran' => $method,
            'status_transaksi' => $initialStatus
        ]);

        if ($transaksi) {
            // Redirect to order detail page for payment
            return redirect()->route('pembeli.order.show', $transaksi->transaksi_id)->with(['key'=>'success','value'=>'Pesanan berhasil dibuat. Silakan lanjutkan pembayaran.']);
        }

        return back()->with(['key'=>'error','value'=>'Gagal membuat pesanan.'])->withInput();
    }

    // Show order detail and payment upload form
    public function showOrder($id)
    {
        if (!session('logged_in') || session('role') !== 'pembeli') {
            return redirect('/login/pembeli');
        }

        $t = Transaksi::with(['menu','lapak','user'])->findOrFail($id);
        // ensure belongs to current user
        if ($t->user_id != session('user_id')) {
            abort(403);
        }

        return view('pembeli.order_show', compact('t'));
    }

    // Upload payment proof
    public function uploadProof(Request $request, $id)
    {
        if (!session('logged_in') || session('role') !== 'pembeli') {
            return redirect('/login/pembeli');
        }

        $t = Transaksi::findOrFail($id);
        if ($t->user_id != session('user_id')) abort(403);

        $data = $request->validate([
            'bukti' => 'required|file|image|max:5120'
        ]);

        $file = $request->file('bukti');
        $path = $file->store('payments', 'public');

        $t->bukti_pembayaran = $path;
        $t->status_transaksi = 'menunggu_konfirmasi';
        $t->save();

        return redirect()->route('pembeli.lapak.select')->with(['key'=>'success','value'=>'Bukti pembayaran terkirim. Menunggu konfirmasi dari penjual.']);
    }

    /**
     * Pembeli konfirmasi bahwa pesanan sudah diterima
     */
    public function confirmReceived(Request $request, $id)
    {
        if (!session('logged_in') || session('role') !== 'pembeli') {
            return redirect('/login/pembeli');
        }

        $t = Transaksi::findOrFail($id);
        if ($t->user_id != session('user_id')) {
            abort(403);
        }

        // hanya boleh konfirmasi jika status = 'siap' atau 'sedang_dibuat' jika ingin
        if (!in_array($t->status_transaksi, ['siap'])) {
            return redirect()->back()->with(['key'=>'error','value'=>'Transaksi belum siap untuk dikonfirmasi.']);
        }

        $t->status_transaksi = 'selesai';
        $t->save();

        return redirect()->route('pembeli.riwayat')->with(['key'=>'success','value'=>'Terima kasih — pesanan sudah dikonfirmasi selesai.']);
    }

    /**
     * Menampilkan riwayat pesanan pembeli
     */
    public function riwayatPesanan()
    {
        if (!session('logged_in') || session('role') !== 'pembeli') {
            return redirect('/login/pembeli');
        }

        $transaksis = Transaksi::with(['menu', 'lapak'])
            ->where('user_id', session('user_id'))
            ->orderBy('waktu_transaksi', 'desc')
            ->paginate(10);

        return view('pembeli.riwayat_pesanan', compact('transaksis'));
    }
}
