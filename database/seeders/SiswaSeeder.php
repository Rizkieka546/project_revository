<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('siswa')->insert([
            [
                'siswa_id' => 'SIS001',
                'nisn' => '1234567890',
                'nama_siswa' => 'Andi Wijaya',
                'jurusan_id' => 1,
                'kelas_id' => 1,
                'no_siswa' => '087968790099',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 'SIS002',
                'nisn' => '1234567891',
                'nama_siswa' => 'Budi Santoso',
                'jurusan_id' => 1,
                'kelas_id' => 1,
                'no_siswa' => '087968790099',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 'SIS003',
                'nisn' => '1234567892',
                'nama_siswa' => 'Citra Anggraini',
                'jurusan_id' => 1,
                'kelas_id' => 1,
                'no_siswa' => '087968790099',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 'SIS004',
                'nisn' => '1234567893',
                'nama_siswa' => 'Dedi Prasetyo',
                'jurusan_id' => 1,
                'kelas_id' => 1,
                'no_siswa' => '087968790099',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 'SIS005',
                'nisn' => '1234567894',
                'nama_siswa' => 'Eka Putri',
                'jurusan_id' => 1,
                'kelas_id' => 1,
                'no_siswa' => '087968790099',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 'SIS006',
                'nisn' => '1234567895',
                'nama_siswa' => 'Fajar Nurjaman',
                'jurusan_id' => 1,
                'kelas_id' => 1,
                'no_siswa' => '087968790099',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 'SIS007',
                'nisn' => '1234567896',
                'nama_siswa' => 'Gita Ayu',
                'jurusan_id' => 1,
                'kelas_id' => 1,
                'no_siswa' => '087968790099',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 'SIS008',
                'nisn' => '1234567897',
                'nama_siswa' => 'Hendra Setiawan',
                'jurusan_id' => 1,
                'kelas_id' => 1,
                'no_siswa' => '087968790099',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 'SIS009',
                'nisn' => '1234567898',
                'nama_siswa' => 'Indra Surya',
                'jurusan_id' => 1,
                'kelas_id' => 1,
                'no_siswa' => '087968790099',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 'SIS010',
                'nisn' => '1234567899',
                'nama_siswa' => 'Joko Prabowo',
                'jurusan_id' => 1,
                'kelas_id' => 1,
                'no_siswa' => '087968790099',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
