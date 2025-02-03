<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tm_barang_inventaris')->insert([
            [
                'br_kode' => 'INV202500001',
                'jns_brg_kode' => 'JNS01', // Elektronik
                'user_id' => 'U001',
                'br_nama' => 'Laptop',
                'br_tgl_terima' => Carbon::now(),
                'br_tgl_entry' => Carbon::now(),
                'br_status' => 1, // Status barang aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'br_kode' => 'INV202500002',
                'jns_brg_kode' => 'JNS01', // Elektronik
                'user_id' => 'U001',
                'br_nama' => 'Smartphone',
                'br_tgl_terima' => Carbon::now(),
                'br_tgl_entry' => Carbon::now(),
                'br_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'br_kode' => 'INV202500003',
                'jns_brg_kode' => 'JNS02', // Perabotan
                'user_id' => 'U001',
                'br_nama' => 'Meja',
                'br_tgl_terima' => Carbon::now(),
                'br_tgl_entry' => Carbon::now(),
                'br_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'br_kode' => 'INV202500004',
                'jns_brg_kode' => 'JNS02', // Perabotan
                'user_id' => 'U001',
                'br_nama' => 'Kursi',
                'br_tgl_terima' => Carbon::now(),
                'br_tgl_entry' => Carbon::now(),
                'br_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'br_kode' => 'INV202500005',
                'jns_brg_kode' => 'JNS03', // Kendaraan
                'user_id' => 'U001',
                'br_nama' => 'Sepeda Motor',
                'br_tgl_terima' => Carbon::now(),
                'br_tgl_entry' => Carbon::now(),
                'br_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'br_kode' => 'INV202500006',
                'jns_brg_kode' => 'JNS03', // Kendaraan
                'user_id' => 'U001',
                'br_nama' => 'Mobil',
                'br_tgl_terima' => Carbon::now(),
                'br_tgl_entry' => Carbon::now(),
                'br_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'br_kode' => 'INV202500007',
                'jns_brg_kode' => 'JNS04', // Alat Tulis
                'user_id' => 'U001',
                'br_nama' => 'Pensil',
                'br_tgl_terima' => Carbon::now(),
                'br_tgl_entry' => Carbon::now(),
                'br_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'br_kode' => 'INV202500008',
                'jns_brg_kode' => 'JNS04', // Alat Tulis
                'user_id' => 'U001',
                'br_nama' => 'Penghapus',
                'br_tgl_terima' => Carbon::now(),
                'br_tgl_entry' => Carbon::now(),
                'br_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'br_kode' => 'INV202500009',
                'jns_brg_kode' => 'JNS05', // Furnitur
                'user_id' => 'U001',
                'br_nama' => 'Lemari',
                'br_tgl_terima' => Carbon::now(),
                'br_tgl_entry' => Carbon::now(),
                'br_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'br_kode' => 'INV20250010',
                'jns_brg_kode' => 'JNS05', // Furnitur
                'user_id' => 'U001',
                'br_nama' => 'Meja Makan',
                'br_tgl_terima' => Carbon::now(),
                'br_tgl_entry' => Carbon::now(),
                'br_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
