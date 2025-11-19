<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PenjualSeeder extends Seeder
{
    public function run(): void
    {
        // Create a lapak
        $lapakId = DB::table('lapaks')->insertGetId([
            'nama_lapak' => 'Lapak IFA',
            'pemilik' => 'Ifa',
            'no_hp_pemilik' => '081234567890',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create penjual linked to lapak
        DB::table('penjuals')->updateOrInsert([
            'email' => 'ifa@example.com'
        ],[
            'nama_penjual' => 'Ifa Pemilik',
            'password' => Hash::make('123'),
            'no_hp' => '081234567890',
            'lapak_id' => $lapakId,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
