<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBungaSimpanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_simpanan', function (Blueprint $table) {
            $table->float('jumlah_bunga')->nullable()->default(0)->after('jangka_waktu');
            $table->float('jumlah_bunga_efektif')->nullable()->default(0)->after('jangka_waktu');
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
            $table->dropColumn('jumlah_bunga');
            $table->dropColumn('jumlah_bunga_efektif');
        });
    }
}
