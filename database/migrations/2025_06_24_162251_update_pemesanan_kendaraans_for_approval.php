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
        Schema::table('pemesanan_kendaraans', function (Blueprint $table) {
            if (!Schema::hasColumn('pemesanan_kendaraans', 'approver2_id')) {
                $table->foreignId('approver2_id')->nullable()->after('approver1_id')->constrained('users')->onDelete('cascade');
            }

            if (!Schema::hasColumn('pemesanan_kendaraans', 'approved_at_1')) {
                $table->timestamp('approved_at_1')->nullable()->after('status');
            }

            if (!Schema::hasColumn('pemesanan_kendaraans', 'approved_at_2')) {
                $table->timestamp('approved_at_2')->nullable()->after('approved_at_1');
            }

            // Ubah enum jika perlu
            DB::statement("ALTER TABLE pemesanan_kendaraans MODIFY status ENUM('pending', 'menunggu approver 2', 'approved') DEFAULT 'pending'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanan_kendaraans', function (Blueprint $table) {
            $table->dropForeign(['approver2_id']);
            $table->dropColumn(['approver2_id', 'approved_at_1', 'approved_at_2']);

            // Rollback perubahan enum status
            DB::statement("ALTER TABLE pemesanan_kendaraans MODIFY status ENUM('pending', 'approved1', 'approved2') DEFAULT 'pending'");
        });
    }
};
