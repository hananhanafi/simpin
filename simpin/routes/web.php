<?php

use App\Helpers\FunctionHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'SimpinController@index')->name('beranda');
    Route::get('/home', 'SimpinController@index')->name('home');
    Route::get('/setting', 'SimpinController@edit');
    Route::post('/upload', 'SimpinController@uploadfile');
    Route::post('/update', 'SimpinController@update');

    Route::name('master.')->namespace('Master')->prefix('master')->group(function () {
        Route::resource('produk-kategori', 'ProdukKategoriController');
        Route::post('produk-kategori-import-xls', 'ProdukKategoriController@importXlsProses')->name('produk-kategori.importXlsProses');
        Route::resource('produk', 'ProdukController');
        Route::post('produk-import-xls', 'ProdukController@importXlsProses')->name('produk.importXlsProses');
        Route::resource('grade', 'GradeController');
        Route::resource('departemen', 'DepartemenController');
        Route::resource('profit', 'ProfitCenterController');
        Route::resource('sumber-dana', 'SumberDanaController');
    });

    Route::name('data.')->namespace('Data')->prefix('data')->group(function () {
        Route::resource('anggota', 'AnggotaController');
        Route::post('anggota-penutupan', 'AnggotaController@penutupan')->name('anggota.penutupan');

        Route::resource('simpanan', 'SimpananController');
        Route::get('simpanan/{id}/detail', 'SimpananController@detail')->name('simpanan.detail');
        Route::post('simpanan-penutupan', 'SimpananController@penutupan')->name('simpanan.penutupan');
        Route::get('simpanan-setor', 'SimpananController@setor')->name('simpanan.setor');
        Route::get('simpanan-tarik', 'SimpananController@tarik')->name('simpanan.tarik');
        Route::post('simpanan-setor-simpan', 'SimpananController@simpan_setor')->name('simpanan.setor.transaksi');
        Route::post('simpanan-tarik-simpan', 'SimpananController@simpan_tarik')->name('simpanan.tarik.transaksi');
        Route::get('simpas-simulasi-xls', 'SimpananController@simpasSimulasiXls')->name('simpanan.simulasi-simpan.xls');
        Route::get('ssb-simulasi-xls', 'SimpananController@ssbSimulasiXls')->name('simpanan.simulasi-ssb.xls');
        Route::get('simpanan-sertif', 'SimpananController@sertif')->name('simpanan.sertif');
        Route::get('simpanan-sertif-pdf/{id}', 'SimpananController@sertifPdf')->name('simpanan.sertif-pdf');

        Route::resource('pinjaman', 'PinjamanController');
        Route::get('pinjaman-simulasi', 'PinjamanController@simulasi')->name('pinjaman.simulasi');
        Route::get('pinjaman-mutasi', 'PinjamanController@mutasi')->name('pinjaman.mutasi');
        Route::get('pinjaman-simulasi-xls', 'PinjamanController@pinjamanSimulasiXls')->name('pinjaman.simulasi.xls');
        Route::get('pinjaman-plafon', 'PinjamanController@plafon')->name('pinjaman.plafon');
        Route::get('pinjaman-plafon-xls', 'PinjamanController@plafonXls')->name('pinjaman.plafon.xls');
        Route::get('pinjaman-pengajuan-xls', 'PinjamanController@pinjamanPengajuanXls')->name('pinjaman.pengajuan.xls');
        Route::get('pinjaman-pencairan', 'PinjamanController@pencairan')->name('pinjaman.pencairan');
        Route::get('pinjaman-pelunasan', 'PinjamanController@pelunasan')->name('pinjaman.pelunasan');

        Route::resource('pembiayaan', 'PembiayaanController');
        Route::get('pembukaan', 'PembiayaanController@pembukaan')->name('pembiayaan.pembukaan');
        Route::get('setoran', 'PembiayaanController@setoran')->name('pembiayaan.setoran');
        Route::get('mutasi', 'PembiayaanController@mutasi')->name('pembiayaan.mutasi');
        Route::get('pembukaan', 'PembiayaanController@pembukaan')->name('pembiayaan.pembukaan');
        Route::get('pelunasanAwal', 'PembiayaanController@pelunasanAwal')->name('pembiayaan.pelunasan-awal');

        // Route::resource('pembayaran', 'PembiayaanController');
        // Route::get('pembukaan', 'PembiayaanController@pembukaan')->name('pembiayaan.pembukaan');
        // Route::get('setoran', 'PembiayaanController@setoran')->name('pembiayaan.setoran');
        // Route::get('mutasi', 'PembiayaanController@mutasi')->name('pembiayaan.mutasi');
        // Route::get('pembukaan', 'PembiayaanController@pembukaan')->name('pembiayaan.pembukaan');
        // Route::get('pelunasanAwal', 'PembiayaanController@pelunasanAwal')->name('pembiayaan.pelunasan-awal');

        Route::resource('shu', 'ShuController');
        Route::get('rincian-anggota', 'ShuController@rincian_anggota')->name('shu.rincian-anggota');
        Route::resource('pengguna', 'PenggunaController');
    });
    Route::name('laporan.')->namespace('Laporan')->prefix('laporan')->group(function () {
        Route::get('anggota', 'LaporanController@anggota')->name('anggota');
        Route::get('simpanan', 'LaporanController@simpanan')->name('simpanan');
        Route::get('simp_ssb', 'LaporanController@simp_ssb')->name('simp-ssb');
        Route::get('simpas', 'LaporanController@simpas')->name('simpas');
    });
    Route::name('datatable.')->prefix('datatable')->group(function () {
        Route::get('produk-kategori', 'DatatableController@produkType')->name('produk-kategori');
        Route::get('produk', 'DatatableController@produk')->name('produk');
        Route::get('grade', 'DatatableController@grade')->name('grade');
        Route::get('departemen', 'DatatableController@departemen')->name('departemen');
        Route::get('profit', 'DatatableController@profit')->name('profit');
        Route::get('sumberdana', 'DatatableController@sumberdana')->name('sumberdana');
        Route::get('simpanan', 'DatatableController@simpanan')->name('simpanan');
        Route::get('simpanan-sertif', 'DatatableController@simpanan_sertif')->name('simpanan.sertif');
        Route::get('pinjaman', 'DatatableController@pinjaman')->name('pinjaman');
        Route::get('shu', 'DatatableController@shu')->name('shu');
        Route::get('pengguna', 'DatatableController@pengguna')->name('pengguna');
        Route::get('anggota', 'DatatableController@anggota')->name('anggota');
        Route::get('rincian-anggota', 'DatatableController@rincian_anggota')->name('rincian-anggota');

        Route::get('anggota-laporan', 'DatatableLaporanController@anggota')->name('laporan.anggota');
        Route::get('simpanan-laporan', 'DatatableLaporanController@simpanan')->name('laporan.simpanan');
        Route::get('simp-ssb-laporan', 'DatatableLaporanController@simp_ssb')->name('laporan.simp-ssb');
        Route::get('simpas-laporan', 'DatatableLaporanController@simpas')->name('laporan.simpas');
    });

    Route::name('approval.')->namespace('Data')->prefix('approval')->group(function () {
        Route::get('produk', 'ApprovalController@produk')->name('produk');
        Route::post('produk-approve', 'ApprovalController@produkApprove')->name('produk.approve');

        Route::get('anggota', 'ApprovalController@anggota')->name('anggota');
        Route::post('anggota-approve', 'ApprovalController@anggotaApprove')->name('anggota.approve');

        Route::get('simpanan', 'ApprovalController@simpanan')->name('simpanan');
        Route::post('simpanan-approve', 'ApprovalController@simpananApprove')->name('simpanan.approve');

        Route::get('pinjaman', 'ApprovalController@pinjaman')->name('pinjaman');
        Route::post('pinjaman-approve', 'ApprovalController@pinjamanApprove')->name('pinjaman.approve');

        Route::get('shu', 'ApprovalController@shu')->name('shu');
        Route::post('shu-approve', 'ApprovalController@shuApprove')->name('shu.approve');
    });

    Route::name('ajax.')->prefix('ajax')->group(function () {
        Route::get('anggota', 'AjaxController@anggota')->name('anggota');
        Route::get('margin-by-produk', 'AjaxController@marginByProduk')->name('margin-by-produk');
        Route::get('simpanan-simulasi', 'AjaxController@simpananSimulasi')->name('simpanan.simulasi');
        Route::get('pinjaman-simulasi', 'AjaxController@pinjamanSimulasi')->name('pinjaman.simulasi');
        Route::get('pinjaman-plafon', 'AjaxController@pinjamanPlafon')->name('pinjaman.plafon');
        Route::get('pinjaman-pengajuan', 'AjaxController@pinjamanPengajuanSimulasi')->name('pinjaman.pengajuan');
        Route::get('shu-simulasi', 'AjaxController@shuSimulasi')->name('shu.simulasi');
        Route::post('get-bungapa-by-marginflat', 'AjaxController@getBungapaByMarginflat');
    });

    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
});

Route::get('artisan', function () {
    $res[] = Artisan::call('migrate');
    $res[] = Artisan::call('config:clear');
    $res[] = Artisan::call('cache:clear');
    $res[] = Artisan::call('config:cache');
    return $res;
});
Route::get('pmt', function () {
    $i  = 0.1;
    $p  = 15000000;
    $n  = 12;
    return FunctionHelper::bungaEfektif($i, $n, $p);
});
Route::get('logout', function () {
    Auth::logout();
    Session::flash('success', 'Anda Berhasil Logout');
    return redirect()->route('login');
});

Auth::routes([
    'register' => false,
    'forget' => false
]);

/** EDIT BY DEDE */
Route::get('/export/produk-kategori', 'Exports@produk_categori')->name('export.produk_kategori');
Route::get('/export/master-produk', 'Exports@master_produk')->name('export.master_produk');
Route::get('/export/master-grade', 'Exports@master_grade')->name('export.master_grade');
Route::get('/export/master-departemen', 'Exports@master_departemen')->name('export.master_departemen');
Route::get('/export/master-profit', 'Exports@master_profit')->name('export.master_profit');
Route::get('/export/master-sumber', 'Exports@master_sumber')->name('export.master_sumber');
Route::get('/export/sertifikat-ssb/{id}', 'Exports@sertifikat_ssb')->name('export.sertifikat_ssb');
