<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembiayaanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembiayaan_detail', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->integer('tabungan_id')->nullable()->default(0);
            $table->string('bulan')->nullable();
            $table->string('tahun')->nullable();
            $table->integer('jlh_hari')->nullable()->default(0);
            $table->double('bunga_flat', 30, 10)->nullable()->default(0);
            $table->double('bunga_pa', 30, 10)->nullable()->default(0);
            $table->double('sisa_hutang', 30, 10)->nullable()->default(0);
            $table->double('sisa_pokok', 30, 10)->nullable()->default(0);
            $table->double('angsuran_pokok', 30, 10)->nullable()->default(0);
            $table->double('angsuran_margin', 30, 10)->nullable()->default(0);
            $table->double('total_angsuran',30,10)->nullable()->default(0);
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
        Schema::dropIfExists('pembiayaan_detail');
    }
}
