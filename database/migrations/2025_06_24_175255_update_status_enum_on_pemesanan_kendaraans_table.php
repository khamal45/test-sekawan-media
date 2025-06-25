<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE pemesanan_kendaraans MODIFY COLUMN status ENUM('pending', 'menunggu approver 2', 'approved', 'rejected') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE pemesanan_kendaraans MODIFY COLUMN status ENUM('pending', 'menunggu approver 2', 'approved') DEFAULT 'pending'");
    }
};
