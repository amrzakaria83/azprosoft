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
            Route::get('/newdb', 'Product_impsController@newdb')->name('newdb');
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

        Route::name('bill_sale_headers.')->prefix('bill_sale_headers')->group(function(){
            Route::get('/','Bill_sale_headersController@index')->name('index');
            Route::get('/show/{id}','Bill_sale_headersController@show')->name('show');
            Route::post('/delete', 'Bill_sale_headersController@destroy')->name('delete');
            Route::get('/create','Bill_sale_headersController@create')->name('create');
            Route::post('/store','Bill_sale_headersController@store')->name('store');
            Route::post('/storemodel','Bill_sale_headersController@storemodel')->name('storemodel');
            Route::get('/edit/{id}', 'Bill_sale_headersController@edit')->name('edit');
            Route::post('/update', 'Bill_sale_headersController@update')->name('update');
        });
        Route::name('emangeremps.')->prefix('emangeremps')->group(function(){
            Route::get('/','EmangerempsController@index')->name('index');
            Route::get('/show/{id}','EmangerempsController@show')->name('show');
            Route::post('/delete', 'EmangerempsController@destroy')->name('delete');
            Route::get('/create','EmangerempsController@create')->name('create');
            Route::post('/store','EmangerempsController@store')->name('store');
            Route::get('/edit/{id}', 'EmangerempsController@edit')->name('edit');
            Route::post('/update', 'EmangerempsController@update')->name('update');
            
        });
        Route::name('pro_products.')->prefix('pro_products')->group(function(){
            Route::get('/','Pro_productsController@index')->name('index');
            Route::get('/show/{id}','Pro_productsController@show')->name('show');
            Route::post('/delete', 'Pro_productsController@destroy')->name('delete');
            Route::get('/create','Pro_productsController@create')->name('create');
            Route::post('/store','Pro_productsController@store')->name('store');
            Route::get('/edit/{id}', 'Pro_productsController@edit')->name('edit');
            Route::post('/update', 'Pro_productsController@update')->name('update');
            
        });
        Route::name('pro_purchase_hs.')->prefix('pro_purchase_hs')->group(function(){
            Route::get('/','Pro_purchase_headersController@index')->name('index');
            Route::get('/show/{id}','Pro_purchase_headersController@show')->name('show');
            Route::post('/delete', 'Pro_purchase_headersController@destroy')->name('delete');
            Route::get('/create','Pro_purchase_headersController@create')->name('create');
            Route::post('/store','Pro_purchase_headersController@store')->name('store');
            Route::get('/edit/{id}', 'Pro_purchase_headersController@edit')->name('edit');
            Route::post('/update', 'Pro_purchase_headersController@update')->name('update');
            Route::get('/indexh_d','Pro_purchase_headersController@indexh_d')->name('indexh_d');
            
        });
        Route::name('pro_purchase_ds.')->prefix('pro_purchase_ds')->group(function(){
            Route::get('/','Pro_purchase_detailssController@index')->name('index');
            Route::get('/show/{id}','Pro_purchase_detailssController@show')->name('show');
            Route::post('/delete', 'Pro_purchase_detailssController@destroy')->name('delete');
            Route::get('/create','Pro_purchase_detailssController@create')->name('create');
            Route::post('/store','Pro_purchase_detailssController@store')->name('store');
            Route::get('/edit/{id}', 'Pro_purchase_detailssController@edit')->name('edit');
            Route::post('/update', 'Pro_purchase_detailssController@update')->name('update');
            
        });
        Route::name('pro_sales_hs.')->prefix('pro_sales_hs')->group(function(){
            Route::get('/','Pro_sales_hsController@index')->name('index');
            Route::get('/show/{id}','Pro_sales_hsController@show')->name('show');
            Route::post('/delete', 'Pro_sales_hsController@destroy')->name('delete');
            Route::get('/create','Pro_sales_hsController@create')->name('create');
            Route::post('/store','Pro_sales_hsController@store')->name('store');
            Route::get('/edit/{id}', 'Pro_sales_hsController@edit')->name('edit');
            Route::post('/update', 'Pro_sales_hsController@update')->name('update');
            
        });
        Route::name('pro_customers.')->prefix('pro_customers')->group(function(){
            Route::get('/','Pro_customersController@index')->name('index');
            Route::get('/show/{id}','Pro_customersController@show')->name('show');
            Route::post('/delete', 'Pro_customersController@destroy')->name('delete');
            Route::get('/create','Pro_customersController@create')->name('create');
            Route::post('/store','Pro_customersController@store')->name('store');
            Route::get('/edit/{id}', 'Pro_customersController@edit')->name('edit');
            Route::post('/update', 'Pro_customersController@update')->name('update');
            
        });
        Route::name('pro_sales_dets.')->prefix('pro_sales_dets')->group(function(){
            Route::get('/','Pro_sales_detsController@index')->name('index');
            Route::get('/show/{id}','Pro_sales_detsController@show')->name('show');
            Route::post('/delete', 'Pro_sales_detsController@destroy')->name('delete');
            Route::get('/create','Pro_sales_detsController@create')->name('create');
            Route::post('/store','Pro_sales_detsController@store')->name('store');
            Route::get('/edit/{id}', 'Pro_sales_detsController@edit')->name('edit');
            Route::post('/update', 'Pro_sales_detsController@update')->name('update');
            Route::get('/reportprodsaledet','Pro_sales_detsController@reportprodsaledet')->name('reportprodsaledet'); // add can
            Route::get('/indexprodsaledet/{from_t?}/{to_d?}','Pro_sales_detsController@indexprodsaledet')->name('indexprodsaledet');
            Route::get('/indexreportsale','Pro_sales_detsController@indexreportsale')->name('indexreportsale'); // add can
            Route::get('/getReportData','Pro_sales_detsController@getReportData')->name('getReportData');
            Route::post('/exportReport', 'Pro_sales_detsController@exportReport')->name('exportReport');
            Route::get('/getfile','Pro_sales_detsController@getfile')->name('getfile');
            Route::get('/indextranssite','Pro_sales_detsController@indextranssite')->name('indextranssite'); // add can
            Route::get('/transReport', 'Pro_sales_detsController@transReport')->name('transReport');

            Route::get('/export','Pro_sales_detsController@export')->name('export');

            Route::post('/prepareExport','Pro_sales_detsController@prepareExport')->name('prepareExport');
            
        });

        Route::name('pro_emp_atts.')->prefix('pro_emp_atts')->group(function(){
            Route::get('/','Pro_emp_attsController@index')->name('index');
            Route::get('/show/{id}','Pro_emp_attsController@show')->name('show');
            Route::post('/delete', 'Pro_emp_attsController@destroy')->name('delete');
            Route::get('/create','Pro_emp_attsController@create')->name('create');
            Route::post('/store','Pro_emp_attsController@store')->name('store');
            Route::get('/edit/{id}', 'Pro_emp_attsController@edit')->name('edit');
            Route::post('/update', 'Pro_emp_attsController@update')->name('update');
            
        });

        Route::name('vacationemps.')->prefix('vacationemps')->group(function(){
            Route::get('/','Vacation_empsController@index')->name('index');
            Route::get('/indexall','Vacation_empsController@indexall')->name('indexall');
            Route::get('/show/{id}','Vacation_empsController@show')->name('show');
            Route::post('/delete', 'Vacation_empsController@destroy')->name('delete');
            Route::get('/create','Vacation_empsController@create')->name('create');
            Route::post('/store','Vacation_empsController@store')->name('store');
            Route::get('/edit/{id}', 'Vacation_empsController@edit')->name('edit');
            Route::post('/update', 'Vacation_empsController@update')->name('update');
            
        });
        Route::name('vacation_causes.')->prefix('vacation_causes')->group(function(){
            Route::get('/','Vacation_causesController@index')->name('index');
            Route::get('/show/{id}','Vacation_causesController@show')->name('show');
            Route::post('/delete', 'Vacation_causesController@destroy')->name('delete');
            Route::get('/create','Vacation_causesController@create')->name('create');
            Route::post('/store','Vacation_causesController@store')->name('store');
            Route::post('/storemodel','Vacation_causesController@storemodel')->name('storemodel');
            Route::get('/edit/{id}', 'Vacation_causesController@edit')->name('edit');
            Route::post('/update', 'Vacation_causesController@update')->name('update');
            
        });
        Route::name('emp_plan_atts.')->prefix('emp_plan_atts')->group(function(){
            Route::get('/','Emp_plan_attsController@index')->name('index');
            Route::get('/show/{id}','Emp_plan_attsController@show')->name('show');
            Route::post('/delete', 'Emp_plan_attsController@destroy')->name('delete');
            Route::get('/create','Emp_plan_attsController@create')->name('create');
            Route::post('/store','Emp_plan_attsController@store')->name('store');
            Route::post('/storemodel','Emp_plan_attsController@storemodel')->name('storemodel');
            Route::get('/edit/{id}', 'Emp_plan_attsController@edit')->name('edit');
            Route::post('/update', 'Emp_plan_attsController@update')->name('update');
            
        });
        Route::name('work_locations.')->prefix('work_locations')->group(function(){
            Route::get('/','Work_locationsController@index')->name('index');
            Route::get('/show/{id}','Work_locationsController@show')->name('show');
            Route::post('/delete', 'Work_locationsController@destroy')->name('delete');
            Route::get('/create','Work_locationsController@create')->name('create');
            Route::post('/store','Work_locationsController@store')->name('store');
            Route::post('/storemodel','Work_locationsController@storemodel')->name('storemodel');
            Route::get('/edit/{id}', 'Work_locationsController@edit')->name('edit');
            Route::post('/update', 'Work_locationsController@update')->name('update');
            
        });
        Route::name('emp_att_permissions.')->prefix('emp_att_permissions')->group(function(){
            Route::get('/','Emp_att_permissionsController@index')->name('index');
            Route::get('/show/{id}','Emp_att_permissionsController@show')->name('show');
            Route::post('/delete', 'Emp_att_permissionsController@destroy')->name('delete');
            Route::get('/create','Emp_att_permissionsController@create')->name('create');
            Route::post('/store','Emp_att_permissionsController@store')->name('store');
            Route::post('/storemodel','Emp_att_permissionsController@storemodel')->name('storemodel');
            Route::get('/edit/{id}', 'Emp_att_permissionsController@edit')->name('edit');
            Route::post('/update', 'Emp_att_permissionsController@update')->name('update');
            Route::get('/indexall','Emp_att_permissionsController@indexall')->name('indexall');
            
        });
        Route::name('emp_att_overtimes.')->prefix('emp_att_overtimes')->group(function(){
            Route::get('/','Emp_att_overtimesController@index')->name('index');
            Route::get('/show/{id}','Emp_att_overtimesController@show')->name('show');
            Route::post('/delete', 'Emp_att_overtimesController@destroy')->name('delete');
            Route::get('/create','Emp_att_overtimesController@create')->name('create');
            Route::post('/store','Emp_att_overtimesController@store')->name('store');
            Route::post('/storemodel','Emp_att_overtimesController@storemodel')->name('storemodel');
            Route::get('/edit/{id}', 'Emp_att_overtimesController@edit')->name('edit');
            Route::post('/update', 'Emp_att_overtimesController@update')->name('update');
            Route::get('/create_bymanger','Emp_att_overtimesController@create_bymanger')->name('create_bymanger');
            Route::post('/storemanger','Emp_att_overtimesController@storemanger')->name('storemanger');
            
        });
        Route::name('emp_salarys.')->prefix('emp_salarys')->group(function(){
            Route::get('/','Emp_salarysController@index')->name('index');
            Route::get('/show/{id}','Emp_salarysController@show')->name('show');
            Route::post('/delete', 'Emp_salarysController@destroy')->name('delete');
            Route::get('/create','Emp_salarysController@create')->name('create');
            Route::post('/store','Emp_salarysController@store')->name('store');
            Route::post('/storemodel','Emp_salarysController@storemodel')->name('storemodel');
            Route::get('/edit/{id}', 'Emp_salarysController@edit')->name('edit');
            Route::post('/update', 'Emp_salarysController@update')->name('update');
            Route::get('/create_bymanger','Emp_salarysController@create_bymanger')->name('create_bymanger');
            Route::post('/storemanger','Emp_salarysController@storemanger')->name('storemanger');
            
        });
        Route::name('emp_monthly_salarys.')->prefix('emp_monthly_salarys')->group(function(){
            Route::get('/','Emp_monthly_salarysController@index')->name('index');
            Route::get('/show/{id}','Emp_monthly_salarysController@show')->name('show');
            Route::post('/delete', 'Emp_monthly_salarysController@destroy')->name('delete');
            Route::get('/create','Emp_monthly_salarysController@create')->name('create');
            Route::post('/store','Emp_monthly_salarysController@store')->name('store');
            Route::post('/storemodel','Emp_monthly_salarysController@storemodel')->name('storemodel');
            Route::get('/edit/{id}', 'Emp_monthly_salarysController@edit')->name('edit');
            Route::post('/update', 'Emp_monthly_salarysController@update')->name('update');
            Route::get('/create_bymanger','Emp_monthly_salarysController@create_bymanger')->name('create_bymanger');
            Route::post('/storemanger','Emp_monthly_salarysController@storemanger')->name('storemanger');
            Route::get('/create_m_sa','Emp_monthly_salarysController@create_m_sa')->name('create_m_sa');
            Route::get('/index_m_sa/{from_time?}/{to_time?}/{work_days?}','Emp_monthly_salarysController@index_m_sa')->name('index_m_sa');
            
        });
        Route::name('emp_actions.')->prefix('emp_actions')->group(function(){
            Route::get('/','Emp_actionsController@index')->name('index');
            Route::get('/show/{id}','Emp_actionsController@show')->name('show');
            Route::post('/delete', 'Emp_actionsController@destroy')->name('delete');
            Route::get('/create','Emp_actionsController@create')->name('create');
            Route::post('/store','Emp_actionsController@store')->name('store');
            Route::post('/storemodel','Emp_actionsController@storemodel')->name('storemodel');
            Route::get('/edit/{id}', 'Emp_actionsController@edit')->name('edit');
            Route::post('/update', 'Emp_actionsController@update')->name('update');
            Route::get('/create_bymanger','Emp_actionsController@create_bymanger')->name('create_bymanger');
            Route::post('/storemanger','Emp_actionsController@storemanger')->name('storemanger');
            
        });

        
    });

});
