<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimpananTutupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simpanan_tutup', function (Blueprint $table) {
            $table->id();
            $table->integer('simpanan_id')->nullable()->default(0);
            $table->integer('id_anggota')->nullable()->default(0);
            $table->string('no_rekening')->nullable();
            $table->string('no_anggota')->nullable();
            $table->string('nama')->nullable();
            $table->string('jenis_simpanan')->nullable();
            $table->date('tgl_pembukaan')->nullable();
            $table->double('saldo',30,16)->nullable();
            $table->double('pinalti',30,16)->nullable();
            $table->string('pph')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('simpanan_tutup');
    }
}
