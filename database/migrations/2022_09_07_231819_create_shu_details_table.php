<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShuDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shu_detail', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->integer('shu_id')->nullable()->default(0);
            $table->integer('tahun')->nullable()->default(0);
            $table->string('keterangan')->nullable();
            $table->float('persen')->nullable()->default(0);
            $table->double('nilai_shu')->nullable()->default(0);
            $table->enum('kategori',['anggota','pengurus'])->nullable();
            $table->integer('status')->nullable()->default(0);
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
        Schema::dropIfExists('shu_detail');
    }
}
