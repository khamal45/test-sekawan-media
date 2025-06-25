<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeApprover1NullableInPemesananKendaraansTable extends Migration
{
    public function up()
    {
        Schema::table('pemesanan_kendaraans', function (Blueprint $table) {
            $table->unsignedBigInteger('approver1_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('pemesanan_kendaraans', function (Blueprint $table) {
            $table->unsignedBigInteger('approver1_id')->nullable(false)->change();
        });
    }
}
