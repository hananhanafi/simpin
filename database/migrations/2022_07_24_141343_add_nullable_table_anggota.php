<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableTableAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_anggota', function (Blueprint $table) {
            $table->string('no_anggota')->nullable()->change();
            $table->string('nama')->nullable()->change();
            $table->string('nik')->nullable()->change();
            $table->string('no_kk')->nullable()->change();
            $table->string('noka_bpjs')->nullable()->change();
            $table->string('tmp_lahir')->nullable()->change();
            $table->string('tgl_lahir')->nullable()->change();
            $table->integer('jenis_kelamin')->nullable()->change();
            $table->string('alamat')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('telepon')->nullable()->change();
            $table->string('telepon_ext')->nullable()->change();
            $table->string('no_ktp')->nullable()->change();
            $table->string('npwp')->nullable()->change();
            $table->string('pekerjaan')->nullable()->change();
            $table->string('lokasi_kerja')->nullable()->change();
            $table->integer('departement_id')->nullable()->change();
            $table->string('departement')->nullable()->change();
            $table->string('section')->nullable()->change();
            $table->string('goldar')->nullable()->change();
            $table->string('agama')->nullable()->change();
            $table->integer('grade_id')->nullable()->change();
            $table->string('grade')->nullable()->change();
            $table->integer('profit_id')->nullable()->change();
            $table->bigInteger('gaji')->nullable()->change();
            $table->string('gaji_updatedt')->nullable()->change();
            $table->string('bank_nama')->nullable()->change();
            $table->string('bank_code')->nullable()->change();
            $table->string('bank_cabang')->nullable()->change();
            $table->string('bank_norek')->nullable()->change();
            $table->string('status_ebanking')->nullable()->change();
            $table->string('passwd')->nullable()->change();
            $table->integer('status_anggota')->nullable()->change();
            $table->string('status_emp')->nullable()->change();
            $table->string('masukkerja_date')->nullable()->change();
            $table->string('catatan')->nullable()->change();
            $table->string('reg_date')->nullable()->change();
            $table->integer('reg_by')->nullable()->change();
            $table->string('update_date')->nullable()->change();
            $table->integer('update_by')->nullable()->change();
            $table->string('terminate_date')->nullable()->change();
            $table->integer('terminate_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_anggota', function (Blueprint $table) {
            //
        });
    }
}
