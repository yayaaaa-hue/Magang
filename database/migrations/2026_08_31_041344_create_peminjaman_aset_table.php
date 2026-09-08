<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman_aset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('aset_id', 100);
            $table->foreign('aset_id')->references('no_reg_pemda')->on('aset_peralatan_mesin')->onDelete('cascade');
            $table->text('keperluan');
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali');
            $table->string('status', 50)->default('Menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_aset');
    }
};
