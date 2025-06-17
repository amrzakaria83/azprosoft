<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ClientLoginController;
use App\Http\Controllers\Auth\AdminLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [AdminLoginController::class ,'showAdminLoginForm'])->name('admin.login');
Route::get('/clear_cache', function () {
    \Artisan::call('storage:link');
});
// Route::get('/',[AdminLoginController::class ,'index'])->name('index');
// Route::get('/', [ClientLoginController::class ,'showClientLoginForm'])->name('client.login');
// Route::get('/login', [ClientLoginController::class ,'showClientLoginForm'])->name('login');
// Route::post('/loginpost', [ClientLoginController::class ,'clientLogin'])->name('client.login.submit');
// Route::get('/logout', [ClientLoginController::class ,'logout'])->name('client.logout');

Route::name('client.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard','HomeController@index')->name('index');

    Route::name('users.')->prefix('users')->group(function(){
        Route::get('/show/{id}','UsersController@show')->name('show');
    });

    Route::name('tickets.')->prefix('tickets')->group(function(){
        Route::get('/','TicketController@index')->name('index');
        Route::get('/show/{id}','TicketController@show')->name('show');
        Route::post('/delete', 'TicketController@destroy')->name('delete');
        Route::get('/create','TicketController@create')->name('create');
        Route::post('/store','TicketController@store')->name('store');
        Route::get('/print/{id}', 'TicketController@print')->name('print');
        Route::get('/check-tickets', 'TicketController@checkticket')->name('checkticket');
        Route::get('/itemticket', 'TicketController@itemticket')->name('itemticket');
        Route::get('/deletecart', 'TicketController@DeleteCart');
        Route::get('/alldeletordercart', 'TicketController@alldeletordercart');
        Route::get('/edit/{id}', 'TicketController@edit')->name('edit');
        Route::post('/update', 'TicketController@update')->name('update');
    });

});
