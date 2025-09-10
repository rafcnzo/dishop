<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\DB;
use DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // Penjual
            [
                'nama' => 'Penjual',
                'username' => 'penjual',
                'email' => 'penjual@gmail.com',
                'password' => Hash::make('password'),
                'jenis_kelamin' => 'L',
                'role' => 'penjual',
            ],
            // Pembeli
            [
                'nama' => 'Pembeli',
                'username' => 'pembeli',
                'email' => 'pembeli@gmail.com',
                'password' => Hash::make('password'),
                'jenis_kelamin' => 'P',
                'role' => 'pembeli',
            ],
        ]);
    }
}
