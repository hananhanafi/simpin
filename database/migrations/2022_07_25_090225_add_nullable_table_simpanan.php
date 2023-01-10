<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableTableSimpanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_simpanan', function (Blueprint $table) {
            $table->string('no_rekening')->nullable()->change();
            $table->string('no_anggota')->nullable()->change();
            $table->integer('produk_id')->nullable()->default(0)->change();
            $table->bigInteger('saldo_akhir')->nullable()->default(0)->change();
            $table->bigInteger('setoran_per_bln')->nullable()->default(0)->change();
            $table->integer('jangka_waktu')->nullable()->default(0)->change();
            $table->string('tgl_jatuh_tempo')->nullable()->change();
            $table->integer('status_rekening')->nullable()->default(0)->change();
            $table->string('created_date')->nullable()->change();
            $table->integer('created_by')->nullable()->default(0)->change();
            $table->string('approv_date')->nullable()->change();
            $table->integer('approv_by')->nullable()->default(0)->change();
            $table->string('reject_note')->nullable()->change();
            $table->string('update_date')->nullable()->change();
            $table->integer('update_by')->nullable()->default(0)->change();
            $table->string('delete_date')->nullable()->change();
            $table->string('delete_note')->nullable()->change();
            $table->integer('delete_by')->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_simpanan', function (Blueprint $table) {
            //
        });
    }
}
