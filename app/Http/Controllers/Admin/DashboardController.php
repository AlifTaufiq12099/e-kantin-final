<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Pesanan
        $totalPesanan = Transaksi::count();

        // Pendapatan (format: Rp Xjt)
        $totalPendapatan = Transaksi::where('status_transaksi', 'selesai')->sum('total_harga');
        $pendapatanFormatted = $totalPendapatan > 1000000 
            ? 'Rp ' . number_format($totalPendapatan / 1000000, 1, ',', '.') . 'jt'
            : 'Rp ' . number_format($totalPendapatan, 0, ',', '.');

        // Menu Aktif
        $menuAktif = Menu::where('stok', '>', 0)->count();

        // Total User
        $totalUser = User::count();

        // Pesanan Terbaru (5 terakhir)
        $pesananTerbaru = Transaksi::with(['menu', 'user'])
            ->orderBy('waktu_transaksi', 'desc')
            ->limit(5)
            ->get();

        // Menu Terlaris (5 teratas berdasarkan jumlah terjual)
        $menuTerlarisData = DB::table('menus')
            ->leftJoin('transaksis', function($join) {
                $join->on('menus.menu_id', '=', 'transaksis.menu_id')
                     ->where('transaksis.status_transaksi', '=', 'selesai');
            })
            ->select('menus.menu_id', 
                     DB::raw('COALESCE(SUM(transaksis.jumlah), 0) as total_terjual'), 
                     DB::raw('COALESCE(SUM(transaksis.total_harga), 0) as total_pendapatan'))
            ->groupBy('menus.menu_id')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->get();
        
        $menuTerlaris = collect();
        foreach ($menuTerlarisData as $data) {
            $menu = Menu::find($data->menu_id);
            if ($menu) {
                $menu->total_terjual = $data->total_terjual ?? 0;
                $menu->total_pendapatan = $data->total_pendapatan ?? 0;
                $menuTerlaris->push($menu);
            }
        }
        
        // Fallback: ambil menu terbaru jika tidak ada transaksi
        if ($menuTerlaris->isEmpty()) {
            $menuTerlaris = Menu::limit(5)->get()->map(function($menu) {
                $menu->total_terjual = 0;
                $menu->total_pendapatan = 0;
                return $menu;
            });
        }

        return view('admin.dashboard', compact(
            'totalPesanan',
            'pendapatanFormatted',
            'menuAktif',
            'totalUser',
            'pesananTerbaru',
            'menuTerlaris'
        ));
    }
}
