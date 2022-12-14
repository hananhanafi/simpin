<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPphDetailSimpanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('simpanan_ssb_detail', function (Blueprint $table) {
            $table->double('pph',20,10)->nullable()->default(0)->after('total_hari');
            $table->double('bunga_dibayar',20,10)->nullable()->default(0)->after('pph');
        });
        Schema::table('simpanan_simpas_detail', function (Blueprint $table) {
            $table->double('pph',20,10)->nullable()->default(0)->after('total_bunga');
            $table->double('bunga_dibayar',20,10)->nullable()->default(0)->after('pph');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('simpanan_ssb_detail', function (Blueprint $table) {
            $table->dropColumn('pph');
            $table->dropColumn('bunga_dibayar');
        });
        Schema::table('simpanan_ssb_detail', function (Blueprint $table) {
            $table->dropColumn('pph');
            $table->dropColumn('bunga_dibayar');
        });
    }
}
