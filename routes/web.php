<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/agenda', 'AgendaController@index')->name('agenda.index');
Route::post('/agenda/nueva-agenda', 'AgendaController@store')->name('agenda.store');
Route::get('/agenda/editar-agenda/{id}', 'AgendaController@edit')->name('agenda.edit');
Route::put('/agenda/actualizar-agenda/{id}', 'AgendaController@update')->name('agenda.update');
Route::delete('/agenda/eliminar-agenda/{id}', 'AgendaController@destroy')->name('agenda.destroy');

