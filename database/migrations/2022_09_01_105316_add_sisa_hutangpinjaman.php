<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSisaHutangpinjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_pembiayaan', function (Blueprint $table) {
            $table->double('sisa_hutangs', 30, 10)->nullable()->default(0)->after('saldo_akhir_pokok');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_pembiayaan', function (Blueprint $table) {
            $table->dropColumn('sisa_hutangs');
        });
    }
}
