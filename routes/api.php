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

Route::post('register', 'PetugasController@register');
Route::post('login', 'PetugasController@login');

Route::put('ubahpetugas/{id}', 'PetugasController@update')->middleware('jwt.verify');
Route::delete('hapuspetugas/{id}', 'PetugasController@destroy')->middleware('jwt.verify');

Route::get('datafilm', 'FilmController@show')->middleware('jwt.verify');
Route::post('tambahfilm', 'FilmController@store')->middleware('jwt.verify');
Route::put('ubahfilm/{id}', 'FilmController@update')->middleware('jwt.verify');
Route::delete('hapusfilm/{id}', 'FilmController@destroy')->middleware('jwt.verify');

Route::get('datastudio', 'StudioController@show')->middleware('jwt.verify');
Route::post('tambahstudio', 'StudioController@store')->middleware('jwt.verify');
Route::put('ubahstudio/{id}', 'StudioController@update')->middleware('jwt.verify');
Route::delete('hapusstudio/{id}', 'StudioController@destroy')->middleware('jwt.verify');

Route::post('jadwaltayang', 'TayangController@show')->middleware('jwt.verify');
Route::post('tambahtayang', 'TayangController@store')->middleware('jwt.verify');
Route::put('ubahtayang/{id}', 'TayangController@update')->middleware('jwt.verify');
Route::delete('hapustayang/{id}', 'TayangController@destroy')->middleware('jwt.verify');

Route::post('tiket/{id}', 'TiketController@show')->middleware('jwt.verify');
Route::post('tambahtiket', 'TiketController@store')->middleware('jwt.verify');
Route::put('ubahtiket/{id}', 'TiketController@update')->middleware('jwt.verify');
Route::delete('hapustiket/{id}', 'TiketController@destroy')->middleware('jwt.verify');

