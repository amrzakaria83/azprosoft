<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Auth\SuperAdminLoginController;


Auth::routes();

Route::get('/lang-change', [HomeController::class ,'changLang'])->name('admin.lang.change');
Route::get('/login', [AdminLoginController::class ,'showAdminLoginForm'])->name('admin.login');
Route::post('/login', [AdminLoginController::class ,'adminLogin'])->name('admin.login.submit');
Route::get('/logout', [AdminLoginController::class ,'logout'])->name('admin.logout');

Route::name('admin.')->middleware(['auth:admin'])->group(function () {

    Route::middleware(['emp-access:0'])->group(function () {

        Route::get('/','HomeController@index')->name('index');

        Route::name('settings.')->prefix('settings')->group(function(){
            Route::get('/edit/{id}', 'SettingsController@edit')->name('edit');
            Route::post('/update', 'SettingsController@update')->name('update');
        });

        Route::name('employees.')->prefix('employees')->group(function(){
            Route::get('/','EmployeesController@index')->name('index');
            Route::get('/show/{id}','EmployeesController@show')->name('show');
            Route::post('/delete', 'EmployeesController@destroy')->name('delete');
            Route::get('/create','EmployeesController@create')->name('create');
            Route::post('/store','EmployeesController@store')->name('store');
            Route::get('/edit/{id}', 'EmployeesController@edit')->name('edit');
            Route::post('/update', 'EmployeesController@update')->name('update');
            Route::get('/import','EmployeesController@import')->name('import');
            Route::post('/importfile','EmployeesController@importfile')->name('importfile');
            Route::post('/importstore','EmployeesController@importstore')->name('importstore');
        });
        Route::name('roles.')->prefix('roles')->group(function(){
            Route::get('/','RolesController@index')->name('index');
            Route::post('/delete', 'RolesController@destroy')->name('delete')->can('role delete');
            Route::get('/create','RolesController@create')->name('create')->can('role new');
            Route::post('/store','RolesController@store')->name('store');
            Route::get('/edit/{id}', 'RolesController@edit')->name('edit')->can('role edit');
            Route::post('/update', 'RolesController@update')->name('update');
        });
        Route::name('users.')->prefix('users')->group(function(){
            Route::get('/','UsersController@index')->name('index');
            Route::get('/show/{id}','UsersController@show')->name('show');
            Route::post('/delete', 'UsersController@destroy')->name('delete');
            Route::get('/create','UsersController@create')->name('create');
            Route::post('/store','UsersController@store')->name('store');
            Route::get('/edit/{id}', 'UsersController@edit')->name('edit');
            Route::post('/update', 'UsersController@update')->name('update');
        });
        
        Route::name('messages.')->prefix('messages')->group(function(){
            Route::get('/','MessagesController@index')->name('index');
            Route::get('/inbox','MessagesController@inbox')->name('inbox');
            Route::get('/reportcc','MessagesController@reportcc')->name('reportcc');
            Route::get('/show/{id}','MessagesController@show')->name('show');
            Route::post('/delete', 'MessagesController@destroy')->name('delete');
            Route::get('/create','MessagesController@create')->name('create');
            Route::post('/store','MessagesController@store')->name('store');
            Route::get('/edit/{id}', 'MessagesController@edit')->name('edit');
            Route::post('/update', 'MessagesController@update')->name('update');
            Route::get('/response/{id}', 'MessagesController@response')->name('response');
            Route::post('/send_response/{id}', 'MessagesController@send_response')->name('send_response');
        });
        
        Route::name('azcustomers.')->prefix('azcustomers')->group(function(){
            Route::get('/','AzcustomersController@index')->name('index');
            Route::get('/show/{id}','AzcustomersController@show')->name('show');
            Route::post('/delete', 'AzcustomersController@destroy')->name('delete');
            Route::get('/create','AzcustomersController@create')->name('create');
            Route::post('/store','AzcustomersController@store')->name('store');
            Route::get('/edit/{id}', 'AzcustomersController@edit')->name('edit');
            Route::post('/update', 'AzcustomersController@update')->name('update');
            Route::get('/import','AzcustomersController@import')->name('import');
            Route::get('/updatephone','AzcustomersController@updatephone')->name('updatephone');
            Route::get('/updatephone2','AzcustomersController@updatephone2')->name('updatephone2');
            Route::post('/importfile','AzcustomersController@importfile')->name('importfile');
            Route::post('/importstore','AzcustomersController@importstore')->name('importstore');
            
        });

        Route::name('product_imps.')->prefix('product_imps')->group(function(){
            Route::get('/','Product_impsController@index')->name('index');
            Route::get('/show/{id}','Product_impsController@show')->name('show');
            Route::post('/delete', 'Product_impsController@destroy')->name('delete');
            Route::get('/create','Product_impsController@create')->name('create');
            Route::post('/store','Product_impsController@store')->name('store');
            Route::get('/edit/{id}', 'Product_impsController@edit')->name('edit');
            Route::get('/update', 'Product_impsController@update')->name('update');
            Route::post('/import','Product_impsController@import')->name('import');
            Route::get('/createimport','Product_impsController@createimport')->name('createimport');
            Route::get('/startSync', 'Product_impsController@startSync')->name('startSync');
        });

        Route::name('unites.')->prefix('unites')->group(function(){
            Route::get('/','UnitesController@index')->name('index');
            Route::get('/show/{id}','UnitesController@show')->name('show');
            Route::post('/delete', 'UnitesController@destroy')->name('delete');
            Route::get('/create','UnitesController@create')->name('create');
            Route::post('/store','UnitesController@store')->name('store');
            Route::post('/storemodel','UnitesController@storemodel')->name('storemodel');
            Route::get('/edit/{id}', 'UnitesController@edit')->name('edit');
            Route::post('/update', 'UnitesController@update')->name('update');
        });

        
    });

});
