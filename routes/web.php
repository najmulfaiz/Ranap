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
    Route::resource('ranap', 'RanapController');
    Route::get('ranap/{pendaftaran_id}/tindakan', 'RanapController@tindakan')->name('ranap.tindakan');
    Route::post('ranap/tindakan', 'PembayaranController@tindakan')->name('pembayaran.tindakan');
    Route::get('ranap/{pendaftaran_id}/pembayaran', 'PembayaranController@show')->name('ranap.pembayaran');
});