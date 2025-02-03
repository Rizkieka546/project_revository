<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tm_user')->insert([
            [
                'user_id' => 'U001',
                'user_nama' => 'superuser',
                'user_pass' => bcrypt('ekasuperuser'),
                'user_hak' => 'su',
                'user_sts' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 'U002',
                'user_nama' => 'admin',
                'user_pass' => bcrypt('ekaadmin'),
                'user_hak' => 'admin',
                'user_sts' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 'U003',
                'user_nama' => 'operator',
                'user_pass' => bcrypt('ekaoperator'),
                'user_hak' => 'operator',
                'user_sts' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
