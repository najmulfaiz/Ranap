<?php

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('dokter', 'DokterController')->except(['show']);
    Route::resource('ruang', 'RuangController')->except(['show']);
    Route::resource('tarif', 'TarifController')->except(['show']);
    Route::resource('penjamin', 'PenjaminController')->except(['show']);
    Route::resource('pendaftaran', 'PendaftaranController')->except(['show']);

    // SIMPAN TINDAKAN
    Route::post('ranap/tindakan', 'PembayaranController@tindakan')->name('pembayaran.tindakan');

    // MENU RUANG RAWAT INAP
    Route::resource('ranap', 'RanapController');
    Route::get('ranap/{pendaftaran_id}/tindakan', 'RanapController@tindakan')->name('ranap.tindakan');
    Route::get('ranap/{pendaftaran_id}/pembayaran', 'RanapController@list')->name('ranap.pembayaran');

    // MENU LABORATORIUM
    Route::resource('laboratorium', 'LaboratoriumController');
    Route::get('laboratorium/{pendaftaran_id}/tindakan', 'LaboratoriumController@tindakan')->name('laboratorium.tindakan');

    // MENU PEMBAYARAN
    Route::resource('pembayaran', 'PembayaranController');

    // MENU APOTEK
    Route::resource('obat', 'ObatController');
    Route::resource('penjualan', 'PenjualanController');
});