<?php

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('dokter', 'DokterController')->except(['show']);
Route::resource('ruang', 'RuangController')->except(['show']);
Route::resource('tarif', 'TarifController')->except(['show']);
Route::resource('penjamin', 'PenjaminController')->except(['show']);
Route::resource('pendaftaran', 'PendaftaranController')->except(['show']);