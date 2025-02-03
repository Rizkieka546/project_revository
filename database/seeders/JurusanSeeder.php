<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jurusan')->insert([
            [
                'id' => '1',
                'nama_jurusan' => 'PPLG RPl',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
