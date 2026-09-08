<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Master
        User::updateOrCreate(
            ['email' => 'master@kominfo.go.id'],
            [
                'nama' => 'Admin Master Kominfo',
                'password' => Hash::make('password123'),
                'role' => 'admin_master',
                'instansi_bidang' => 'Diskominfo Bonebol',
            ]
        );

        // 2. Akun Admin Biasa
        User::updateOrCreate(
            ['email' => 'admin@kominfo.go.id'],
            [
                'nama' => 'Administrator Kominfo',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'instansi_bidang' => 'Diskominfo Bonebol',
            ]
        );

        // 2. Akun Mahasiswa
        User::updateOrCreate(
            ['email' => 'mahasiswa@gmail.com'],
            [
                'nama' => 'Mahasiswa Magang',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'instansi_bidang' => 'Universitas Negeri Gorontalo',
            ]
        );

        // 3. Akun Pegawai
        User::updateOrCreate(
            ['email' => 'pegawai@gmail.com'],
            [
                'nama' => 'Pegawai Pemkab',
                'password' => Hash::make('password123'),
                'role' => 'pegawai',
                'instansi_bidang' => 'Pemkab Bonebol',
            ]
        );
    }
}