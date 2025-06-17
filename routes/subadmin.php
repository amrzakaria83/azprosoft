<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SubAdminLoginController;
use App\Http\Controllers\Subadmin\HomeController;

Auth::routes();

Route::get('/lang-change', [HomeController::class ,'changLang'])->name('subadmin.lang.change');
Route::get('/login', [SubAdminLoginController::class ,'showAdminLoginForm'])->name('subadmin.login');
Route::post('/login', [SubAdminLoginController::class ,'adminLogin'])->name('subadmin.login.submit');
Route::get('/logout', [SubAdminLoginController::class ,'logout'])->name('subadmin.logout');

Route::name('subadmin.')->middleware(['auth:subadmin'])->group(function () {

    Route::middleware(['emp-access:2'])->group(function () {

        Route::get('/','HomeController@index')->name('index');

        Route::name('settings.')->prefix('settings')->group(function(){
            Route::get('/edit/{id}', 'SettingsController@edit')->name('edit');
            Route::post('/update', 'SettingsController@update')->name('update');
        });
        Route::post('/in_attendance', 'HomeController@in_attendance')->name('in_attendance');
        Route::post('/out_attendance', 'HomeController@out_attendance')->name('out_attendance');
        Route::get('/getemp', 'HomeController@getemp')->name('getemp');
        Route::get('/get_cashiar_value', 'HomeController@get_cashiar_value')->name('get_cashiar_value');

        Route::name('employees.')->prefix('employees')->group(function(){
            Route::get('/','EmployeesController@index')->name('index');
            Route::get('/show/{id}','EmployeesController@show')->name('show');
            Route::post('/delete', 'EmployeesController@destroy')->name('delete');
            Route::get('/create','EmployeesController@create')->name('create');
            Route::post('/store','EmployeesController@store')->name('store');
            Route::get('/edit/{id}', 'EmployeesController@edit')->name('edit');
            Route::post('/update', 'EmployeesController@update')->name('update');
            Route::post('/jobadd', 'EmployeesController@jobadd')->name('jobadd');
            Route::post('/bankadd', 'EmployeesController@bankadd')->name('bankadd');
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
        Route::name('cashiers.')->prefix('cashiers')->group(function(){
            Route::get('/','CashiersController@index')->name('index');
            Route::get('/show/{id}','CashiersController@show')->name('show');
            Route::post('/delete', 'CashiersController@destroy')->name('delete');
            Route::get('/create','CashiersController@create')->name('create');
            Route::post('/store','CashiersController@store')->name('store');
            Route::get('/edit/{id}', 'CashiersController@edit')->name('edit');
            Route::post('/update', 'CashiersController@update')->name('update');
            Route::get('/get_cash_money_trans', 'CashiersController@get_cash_money_trans')->name('get_cash_money_trans');
            Route::get('/get_recivedcash_money_trans', 'CashiersController@get_recivedcash_money_trans')->name('get_recivedcash_money_trans');
            Route::get('/recivedcash_money_trans', 'CashiersController@recivedcash_money_trans')->name('recivedcash_money_trans');
            Route::get('/done_recived_money/{id}/{status}', 'CashiersController@done_recived_money')->name('done_recived_money');
            Route::post('/cash_out_cashier', 'CashiersController@cash_out_cashier')->name('cash_out_cashier');
        });
        Route::name('sites.')->prefix('sites')->group(function(){
            Route::get('/','SitesController@index')->name('index');
            Route::get('/show/{id}','SitesController@show')->name('show');
            Route::post('/delete', 'SitesController@destroy')->name('delete');
            Route::get('/create','SitesController@create')->name('create');
            Route::post('/store','SitesController@store')->name('store');
            Route::get('/edit/{id}', 'SitesController@edit')->name('edit');
            Route::post('/update', 'SitesController@update')->name('update');
        });
        Route::name('drug_requests.')->prefix('drug_requests')->group(function(){
            Route::get('/','Drug_requestsController@index')->name('index');
            Route::get('/datatable2','Drug_requestsController@datatable2')->name('datatable2');
            Route::get('/spe','Drug_requestsController@spe')->name('spe');
            Route::get('/show/{id}','Drug_requestsController@show')->name('show');
            Route::post('/delete', 'Drug_requestsController@destroy')->name('delete');
            Route::get('/indexsite','Drug_requestsController@indexsite')->name('indexsite');
            Route::get('/create','Drug_requestsController@create')->name('create');
            Route::post('/store','Drug_requestsController@store')->name('store');
            Route::get('/edit/{id}', 'Drug_requestsController@edit')->name('edit');
            Route::post('/update', 'Drug_requestsController@update')->name('update');
            Route::get('/getprod', 'Drug_requestsController@getprod')->name('getprod');
            Route::get('/ProdName', 'Drug_requestsController@ProdName')->name('ProdName');
            Route::get('/done/{id}/{status}', 'Drug_requestsController@done')->name('done');
            Route::get('/import','Drug_requestsController@import')->name('import');
            Route::post('/importfile','Drug_requestsController@importfile')->name('importfile');
            Route::post('/importstore','Drug_requestsController@importstore')->name('importstore');

        });
        Route::name('order_ph_requests.')->prefix('order_ph_requests')->group(function(){
            Route::get('/','Order_ph_requestsController@index')->name('index');
            Route::get('/indexdone','Order_ph_requestsController@indexdone')->name('indexdone');
            Route::get('/show/{id}','Order_ph_requestsController@show')->name('show');
            Route::post('/delete', 'Order_ph_requestsController@destroy')->name('delete');
            Route::get('/create','Order_ph_requestsController@create')->name('create');
            Route::post('/store','Order_ph_requestsController@store')->name('store');
            Route::get('/edit/{id}', 'Order_ph_requestsController@edit')->name('edit');
            Route::post('/update', 'Order_ph_requestsController@update')->name('update');
            Route::get('/getempdel', 'Order_ph_requestsController@getempdel')->name('getempdel');
            Route::get('/getempdelselect', 'Order_ph_requestsController@getempdelselect')->name('getempdelselect');
            Route::get('/getemp', 'Order_ph_requestsController@getemp')->name('getemp');
            Route::get('/done/{id}/{status}', 'Order_ph_requestsController@done')->name('done');

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
        Route::name('trans_ph_requests.')->prefix('trans_ph_requests')->group(function(){
            Route::get('/','Trans_ph_requestsController@index')->name('index');
            Route::get('/datatable2','Trans_ph_requestsController@datatable2')->name('datatable2');
            Route::get('/spe','Trans_ph_requestsController@spe')->name('spe');
            Route::get('/show/{id}','Trans_ph_requestsController@show')->name('show');
            Route::post('/delete', 'Trans_ph_requestsController@destroy')->name('delete');
            Route::get('/indexsite','Trans_ph_requestsController@indexsite')->name('indexsite');
            Route::get('/create','Trans_ph_requestsController@create')->name('create');
            Route::get('/createchange/{id}','Trans_ph_requestsController@create')->name('createchange');
            Route::post('/store','Trans_ph_requestsController@store')->name('store');
            Route::get('/edit/{id}', 'Trans_ph_requestsController@edit')->name('edit');
            Route::post('/storechange', 'Trans_ph_requestsController@storechange')->name('storechange');
            Route::post('/update', 'Trans_ph_requestsController@update')->name('update');
            Route::get('/getempdel', 'Trans_ph_requestsController@getempdel')->name('getempdel');
            Route::get('/getemp', 'Trans_ph_requestsController@getemp')->name('getemp');
            Route::get('/done/{id}/{status}', 'Trans_ph_requestsController@done')->name('done');
            Route::get('/changedel/{id}', 'Trans_ph_requestsController@changedel')->name('changedel');

        });
        Route::name('attendances.')->prefix('attendances')->group(function(){
            Route::get('/','AttendanceController@index')->name('index');
            Route::get('/index_in','AttendanceController@index_in')->name('index_in');
            Route::get('/index_all','AttendanceController@index_all')->name('index_all');
            Route::get('/show/{id}','AttendanceController@show')->name('show');
            Route::post('/delete', 'AttendanceController@destroy')->name('delete');
            Route::post('/store','AttendanceController@store')->name('store');
            Route::get('/edit/{id}', 'AttendanceController@edit')->name('edit');
            Route::post('/update', 'AttendanceController@update')->name('update');
            Route::get('/out_attendance/{id}/', 'AttendanceController@out_attendance')->name('out_attendance');
            Route::get('/getempdel', 'AttendanceController@getempdel')->name('getempdel');
            Route::get('/getempdelselect', 'AttendanceController@getempdelselect')->name('getempdelselect');
            Route::get('/getemp', 'AttendanceController@getemp')->name('getemp');
            Route::get('/done/{id}/{status}', 'AttendanceController@done')->name('done');

        });
        Route::name('delivery_customers.')->prefix('delivery_customers')->group(function(){
            Route::get('/','Delevery_cosController@indexcutomer_del_all_data')->name('indexcutomer_del_all_data');
            Route::get('/show/{id}','Delevery_cosController@show')->name('show');
            Route::post('/delete', 'Delevery_cosController@destroy')->name('delete');
            Route::get('/create','Delevery_cosController@create')->name('create');
            Route::post('/storecutomer_del_all_data','Delevery_cosController@storecutomer_del_all_data')->name('storecutomer_del_all_data');
            Route::get('/editcutomer_del_all_data/{id}', 'Delevery_cosController@editcutomer_del_all_data')->name('editcutomer_del_all_data');
            Route::post('/updatecutomer_del_all_data', 'Delevery_cosController@updatecutomer_del_all_data')->name('updatecutomer_del_all_data');

        });
        Route::name('delevery_cos.')->prefix('delevery_cos')->group(function(){
            Route::get('/','Delevery_cosController@index')->name('index');
            Route::get('/show','Delevery_cosController@show')->name('show');
            Route::post('/delete', 'Delevery_cosController@destroy')->name('delete');
            Route::get('/create','Delevery_cosController@create')->name('create');
            Route::get('/del_returen_index_view', 'Delevery_cosController@del_returen_index_view')->name('del_returen_index_view');
            Route::post('/storecutomer_del','Delevery_cosController@storecutomer_del')->name('storecutomer_del');
            Route::get('/get_note/{del_code}','Delevery_cosController@get_note')->name('get_note');
            Route::get('/store','Delevery_cosController@store')->name('store');
            Route::get('/storestable','Delevery_cosController@storestable')->name('storestable');
            Route::get('/delivery_order_requests_add','Delevery_cosController@delivery_order_requests_add')->name('delivery_order_requests_add');
            Route::get('/delivery_order_requests_out','Delevery_cosController@delivery_order_requests_out')->name('delivery_order_requests_out');
            Route::get('/delivery_stable_requests_add','Delevery_cosController@delivery_stable_requests_add')->name('delivery_stable_requests_add');
            Route::get('/delivery_stable_requests_out','Delevery_cosController@delivery_stable_requests_out')->name('delivery_stable_requests_out');
            Route::get('/getdelselect', 'Delevery_cosController@getdelselect')->name('getdelselect');
            Route::get('/getcutomer_del', 'Delevery_cosController@getcutomer_del')->name('getcutomer_del');
            Route::get('/getcutomer_del_id/{id}', 'Delevery_cosController@getcutomer_del_id')->name('getcutomer_del_id');
            Route::get('/getdelselect1', 'Delevery_cosController@getdelselect1')->name('getdelselect1');
            Route::get('/getdelselect', 'Delevery_cosController@getdelselect')->name('getdelselect');
            Route::get('/getdelname', 'Delevery_cosController@getdelname')->name('getdelname');
            Route::get('/delivery_attendace_in', 'Delevery_cosController@delivery_attendace_in')->name('delivery_attendace_in');
            Route::post('/moove', 'Delevery_cosController@moove')->name('moove');
            Route::get('/remoove/{id}/{status}', 'Delevery_cosController@remoove')->name('remoove');
            Route::post('/moove_stable', 'Delevery_cosController@moove_stable')->name('moove_stable');
            Route::get('/remoove_stable/{id}/{status}', 'Delevery_cosController@remoove_stable')->name('remoove_stable');
            Route::get('/remoove_done', 'Delevery_cosController@remoove_done')->name('remoove_done');
            Route::get('/remoove_done_all/{del_code}', 'Delevery_cosController@remoove_done_all')->name('remoove_done_all');
            Route::get('/delivery_stable_requests_add_view','Delevery_cosController@delivery_stable_requests_add_view')->name('delivery_stable_requests_add_view');
            Route::get('/delivery_order_requests_out_payment','Delevery_cosController@delivery_order_requests_out_payment')->name('delivery_order_requests_out_payment');
            Route::get('/delivery_order_requests_stable_payment/{del_code?}','Delevery_cosController@delivery_order_requests_stable_payment')->name('delivery_order_requests_stable_payment');
            Route::get('/delivery_order_requests_stable__delay_payment/{cust_del_code?}','Delevery_cosController@delivery_order_requests_stable__delay_payment')->name('delivery_order_requests_stable__delay_payment');
            Route::get('/del_returen_index','Delevery_cosController@del_returen_index')->name('del_returen_index');
            Route::get('/cust_delay_payment','Delevery_cosController@cust_delay_payment')->name('cust_delay_payment');
            Route::get('/get_totalorder_request','Delevery_cosController@get_totalorder_request')->name('get_totalorder_request');
            Route::get('/edit_note/{id}/{note}','Delevery_cosController@edit_note')->name('edit_note');
            Route::get('/edit_status_payment/{id}/{status_payment}','Delevery_cosController@edit_status_payment')->name('edit_status_payment');
            Route::get('/edit_status_stable_payment/{id}/{status_payment}','Delevery_cosController@edit_status_stable_payment')->name('edit_status_stable_payment');
            Route::get('/edit_value_return_stable_total_delay/{id}/{status_payment}','Delevery_cosController@edit_value_return_stable_total_delay')->name('edit_value_return_stable_total_delay');
            Route::get('/edit_value_return/{id}/{value_return}','Delevery_cosController@edit_value_return')->name('edit_value_return');
            Route::get('/edit_value_return_stable/{id}/{value_return}','Delevery_cosController@edit_value_return_stable')->name('edit_value_return_stable');
            Route::get('/edit_value_return_stable_no_total/{id}/{value_return}','Delevery_cosController@edit_value_return_stable_no_total')->name('edit_value_return_stable_no_total');
            Route::get('/edit_value_return_stable_total/{id}/{totalValue}','Delevery_cosController@edit_value_return_stable_total')->name('edit_value_return_stable_total');
            Route::get('/submit_totalorder_del/{del_code}','Delevery_cosController@submit_totalorder_del')->name('submit_totalorder_del');
            Route::get('/submit_cust_del_delay_payment/{cust_del_code?}','Delevery_cosController@submit_cust_del_delay_payment')->name('submit_cust_del_delay_payment');
            Route::get('/del_report_index','Delevery_cosController@del_report_index')->name('del_report_index');
            Route::get('/del_report_order_done','Delevery_cosController@del_report_order_done')->name('del_report_order_done');
            Route::get('/del_report_stable_done','Delevery_cosController@del_report_stable_done')->name('del_report_stable_done');
            // Route::post('/del_report_index/{del_code}','Delevery_cosController@del_report_index_delcode')->name('del_report_index');
            Route::get('/not_submit_totalorder_del','Delevery_cosController@not_submit_totalorder_del')->name('not_submit_totalorder_del');
            Route::get('/del_report_index_notsupply','Delevery_cosController@del_report_index_notsupply')->name('del_report_index_notsupply');
            Route::get('/del_report_index_notsupply_delay','Delevery_cosController@del_report_index_notsupply_delay')->name('del_report_index_notsupply_delay');
            Route::get('/get_report_data','Delevery_cosController@get_report_data')->name('get_report_data');
            Route::get('/delivery_order_done_report','Delevery_cosController@delivery_order_done_report')->name('delivery_order_done_report');
            Route::get('/delivery_stable_done_report','Delevery_cosController@delivery_stable_done_report')->name('delivery_stable_done_report');
            Route::get('/delivery_income_value_report','Delevery_cosController@delivery_income_value_report')->name('delivery_income_value_report');
            Route::get('/total_del_report','Delevery_cosController@total_del_report')->name('total_del_report');
            Route::get('/chart_del','Delevery_cosController@chart_del')->name('chart_del');
            Route::get('/chart_del_search/{to_date?}','Delevery_cosController@chart_del_search')->name('chart_del_search');
            Route::get('/indexcustomer_order_request','Delevery_cosController@indexcustomer_order_request')->name('indexcustomer_order_request');
            Route::post('/supply_cust_del_delay_payment','Delevery_cosController@supply_cust_del_delay_payment')->name('supply_cust_del_delay_payment');
        });
        
        Route::name('trans_dels.')->prefix('trans_dels')->group(function(){
            Route::get('/','Trans_delsController@index')->name('index');
            Route::get('/show/{id}','Trans_delsController@show')->name('show');
            Route::post('/delete', 'Trans_delsController@destroy')->name('delete');
            Route::get('/create','Trans_delsController@create')->name('create');
            Route::post('/store','Trans_delsController@store')->name('store');
            Route::get('/edit/{id}', 'Trans_delsController@edit')->name('edit');
            Route::post('/update', 'Trans_delsController@update')->name('update');
            Route::get('/done/{id?}/{status?}', 'Trans_delsController@done')->name('done');
            Route::get('/cancel/{id?}/{status?}', 'Trans_delsController@cancel')->name('cancel');
            Route::get('/createmang','Trans_delsController@createmang')->name('createmang');
            Route::post('/storemang','Trans_delsController@storemang')->name('storemang');
            Route::post('/storemangwait','Trans_delsController@storemangwait')->name('storemangwait');
            Route::get('/indexmang','Trans_delsController@indexmang')->name('indexmang');
            Route::get('/edit_status/{id?}/{status?}', 'Trans_delsController@edit_status')->name('edit_status');
            Route::get('/edit_to_id/{id?}/{status?}', 'Trans_delsController@edit_to_id')->name('edit_to_id');
            Route::get('/edit_del/{id?}/{status?}', 'Trans_delsController@edit_del')->name('edit_del');
            Route::post('/editno_receit', 'Trans_delsController@editno_receit')->name('editno_receit');
            Route::get('/indexreq','Trans_delsController@indexreq')->name('indexreq');
            Route::get('/indexsite','Trans_delsController@indexsite')->name('indexsite');
            Route::get('/indexsiteondel','Trans_delsController@indexsiteondel')->name('indexsiteondel');
            Route::get('/indexalldelrep','Trans_delsController@indexalldelrep')->name('indexalldelrep');
            Route::get('/indexdel','Trans_delsController@indexdel')->name('indexdel');
            Route::get('/indexdel_view/{del_code?}/{fromdate?}/{todate?}', 'Trans_delsController@indexdel_view')->name('indexdel_view');
            Route::get('/indexreport/{del_code?}/{fromdate?}/{todate?}', 'Trans_delsController@indexreport')->name('indexreport');
            Route::get('/indexreport1/{del_code?}/{fromdate?}/{todate?}', 'Trans_delsController@indexreport1')->name('indexreport1');
            Route::get('/indexdelreport','Trans_delsController@indexdelreport')->name('indexdelreport');
            Route::get('/indexall','Trans_delsController@indexall')->name('indexall');
        });

    });

});
