<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pemesanan_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // pemesan
            $table->foreignId('kendaraan_id')->constrained()->onDelete('cascade');
            $table->string('driver'); // atau bisa foreignId ke table driver jika ada
            $table->foreignId('approver1_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('approver2_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->dateTime('tanggal_pakai');
            $table->text('keperluan');
            $table->enum('status', ['pending', 'approved1', 'approved2', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan_kendaraans');
    }
};
