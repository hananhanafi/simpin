<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimpananSimpasDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simpanan_simpas_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('simpanan_id')->nullable()->default(0);
            $table->integer('produk_id')->nullable()->default(0);
            $table->string('jenis')->nullable();
            $table->string('bulan')->nullable();
            $table->string('tahun')->nullable();
            $table->integer('jlh_hari')->nullable()->default(0);
            $table->double('tabungan_per_bulan', 30, 16)->nullable()->default(0);
            $table->double('bunga_harian', 30, 16)->nullable()->default(0);
            $table->double('saldo_per_bulan', 30, 16)->nullable()->default(0);
            $table->double('total_tabungan', 30, 16)->nullable()->default(0);
            $table->double('total_bunga', 30, 16)->nullable()->default(0);
            $table->double('total_saldo', 30, 16)->nullable()->default(0);
            $table->double('total_saldo_pembulatan',20,16)->nullable()->default(0);
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
        Schema::dropIfExists('simpanan_simpas_detail');
    }
}
