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
});

Route::group(['prefix' => 'datatable', 'as' => 'datatable.'], function(){
    Route::get('dokter', 'DokterController@datatable')->name('dokter');
    Route::get('ruang', 'RuangController@datatable')->name('ruang');
});