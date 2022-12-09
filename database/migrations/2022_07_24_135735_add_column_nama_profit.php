<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNamaProfit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_profit_center', function (Blueprint $table) {
            $table->string('nama')->after('kode')->nullable();
        });
        Schema::table('t_anggota', function (Blueprint $table) {
            $table->string('profit_id')->after('grade')->nullable();
            $table->string('profit')->after('profit_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_profit_center', function (Blueprint $table) {
            $table->dropColumn('nama');
        });
        Schema::table('t_anggota', function (Blueprint $table) {
            $table->dropColumn('profit_id');
            $table->dropColumn('profit');
        });
    }
}
