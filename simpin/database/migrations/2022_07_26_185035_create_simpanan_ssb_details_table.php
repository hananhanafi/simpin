<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimpananSsbDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simpanan_ssb_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('simpanan_id')->nullable()->default(0);
            $table->integer('produk_id')->nullable()->default(0);
            $table->string('jenis')->nullable();
            $table->string('bulan')->nullable();
            $table->string('tahun')->nullable();
            $table->integer('jlh_hari')->nullable()->default(0);
            $table->double('saldo', 20, 16)->nullable()->default(0);
            $table->double('bunga_harian', 20, 16)->nullable()->default(0);
            $table->double('jlh_bunga', 20, 16)->nullable()->default(0);
            $table->integer('total_hari')->null2ble()->default(0);
            $table->double('total_jumlah_bunga',20,16)->nullable()->default(0);
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simpanan_ssb_detail');
    }
}
