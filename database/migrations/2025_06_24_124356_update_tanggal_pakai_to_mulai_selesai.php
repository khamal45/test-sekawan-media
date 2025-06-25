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
        Schema::table('pemesanan_kendaraans', function (Blueprint $table) {
            $table->dropColumn('tanggal_pakai');
            $table->dateTime('tanggal_mulai')->after('approver2_id');
            $table->dateTime('tanggal_selesai')->after('tanggal_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('pemesanan_kendaraans', function (Blueprint $table) {
            $table->dropColumn(['tanggal_mulai', 'tanggal_selesai']);
            $table->dateTime('tanggal_pakai')->after('approver2_id');
        });
    }
};
