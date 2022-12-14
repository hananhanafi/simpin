<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shu', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->integer('tahun')->nullable()->default(0);
            $table->double('alokasi_shu')->nullable()->default(0);
            $table->double('shu_pengurus')->nullable()->default(0);
            $table->double('shu_anggota')->nullable()->default(0);
            $table->float('persen_pengurus')->nullable()->default(0);
            $table->float('persen_anggota')->nullable()->default(0);
            $table->integer('status')->nullable()->default(0);
            $table->text('approve_note')->nullable();
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
        Schema::dropIfExists('shu');
    }
}
