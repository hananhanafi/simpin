<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestamp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_karyawan', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('p_departemen', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('p_grade', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('p_pekerjaan', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('p_pemb_kodetrans', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('p_produk', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('p_produk_margin', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('p_produk_tipe', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('p_profit_center', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('p_simp_kodetrans', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('p_sumberdana', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_anggota', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_anggota_apresiasi', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_anggota_keluarga', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_group', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_menu', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_pembiayaan', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_pembiayaan_transaksi', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_potongan', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_potongan_detail', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_role_menu', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_setting', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_simpanan', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_simpanan_transaksi', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_user', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('t_variables', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('temp_anggota', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('temp_pinjaman', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('temp_simp_mojang', function (Blueprint $table) {
            $table->timestamps();
            $table->softdeletes();
        });
        Schema::table('temp_simp_wajib', function (Blueprint $table) {
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
        Schema::table('m_karyawan', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('p_departemen', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('p_grade', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('p_pekerjaan', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('p_pemb_kodetrans', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('p_produk', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('p_produk_margin', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('p_produk_tipe', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('p_profit_center', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('p_simp_kodetrans', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('p_sumberdana', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_anggota', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_anggota_apresiasi', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_anggota_keluarga', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_group', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_menu', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_pembiayaan', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_pembiayaan_transaksi', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_potongan', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_potongan_detail', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_role_menu', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_setting', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_simpanan', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_simpanan_transaksi', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_user', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('t_variables', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('temp_anggota', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('temp_pinjaman', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('temp_simp_mojang', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
        Schema::table('temp_simp_wajib', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
    }
}
