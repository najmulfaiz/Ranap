<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->group(function(){
    Route::get('dokter', 'DokterController@api')->name('dokter');
    Route::get('pasien', 'PasienController@api')->name('pasien');
    Route::get('ruang/{kelas?}', 'RuangController@api')->name('ruang');
    
    Route::get('provinsi', 'DaerahController@provinsi')->name('provinsi');
    Route::get('kabupaten/{provinsi_id?}', 'DaerahController@kabupaten')->name('kabupaten');
    Route::get('kecamatan/{kecamatan_id?}', 'DaerahController@kecamatan')->name('kecamatan');
    Route::get('kelurahan/{kelurahan_id?}', 'DaerahController@kelurahan')->name('kelurahan');
});

Route::group(['prefix' => 'datatable', 'as' => 'datatable.'], function(){
    Route::get('dokter', 'DokterController@datatable')->name('dokter');
    Route::get('ruang', 'RuangController@datatable')->name('ruang');
    Route::get('tarif', 'TarifController@datatable')->name('tarif');
    Route::get('penjamin', 'PenjaminController@datatable')->name('penjamin');
    Route::get('pendaftaran', 'PendaftaranController@datatable')->name('pendaftaran');
    Route::get('ranap', 'RanapController@datatable')->name('ranap');
    Route::get('laboratorium', 'LaboratoriumController@datatable')->name('laboratorium');
    Route::get('pembayaran', 'PembayaranController@datatable')->name('pembayaran');
    Route::get('obat', 'ObatController@datatable')->name('obat');

    Route::get('ranap/{pendaftaran_id}', 'RanapController@datatableShow')->name('ranap.show');
    Route::get('laboratorium/{pendaftaran_id}', 'LaboratoriumController@datatableShow')->name('laboratorium.show');
    Route::get('pembayaran/{pendaftaran_id}', 'PembayaranController@datatableShow')->name('pembayaran.show');
});

Route::group(['prefix' => 'autocomplete', 'as' => 'autocomplete.'], function(){
    Route::get('tindakan/{jenis_id}', 'TindakanController@autocomplete')->name('tindakan');
});