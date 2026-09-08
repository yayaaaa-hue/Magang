<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin_master', 'admin', 'mahasiswa', 'pegawai') NOT NULL DEFAULT 'mahasiswa'");
        } catch (\Throwable $e) {
            // Abaikan jika database bukan MySQL atau kolom sudah terupdate
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'mahasiswa', 'pegawai') NOT NULL DEFAULT 'mahasiswa'");
        } catch (\Throwable $e) {
            // Abaikan
        }
    }
};
