<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
//        return view('welcome');
        return redirect('admin/login');
    });
//    Route::any('easy', 'Admin\IndexController@easy');
    Route::get('admin/code', 'Admin\LoginController@code');
    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/showcode', 'Admin\LoginController@showcode');

//    Route::any('ipinfo', 'Admin\LoginController@ipinfo');
//    Route::any('getinfo', 'Admin\LoginController@getinfo');
//    Route::get('admin/showcode2', 'Admin\LoginController@showcode2');

});

Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::resource('nav', 'navController');
    Route::resource('user', 'userController');
    Route::resource('employee', 'userController');
    Route::resource('iptable', 'iptableController');
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');
    Route::any('get_data', 'IndexController@get_data');
    Route::any('easy', 'IndexController@easy');
    Route::any('getnav/{panel_id}/{id}', 'IndexController@get_navdata');
    Route::any('vmanager', 'managerController@vmanager');
    Route::any('updatedhcp', 'managerController@updatedhcp');
    Route::any('deldhcp1', 'managerController@deldhcp1');
    Route::any('ipmanager', 'managerController@ipmanager');
    Route::any('ipupdate', 'managerController@ipupdate');
    Route::any('deletemanager', 'managerController@deletemanager');
    Route::any('getipmanager_data', 'managerController@getipmanager_data');
    Route::any('bjlz', 'managerController@bjlz');
    Route::any('bjzz', 'managerController@bjzz');
    Route::any('bjza', 'managerController@bjza');
    Route::any('qcza', 'managerController@qcza');

    Route::any('getmainbar', 'managerController@getmainbar');
    Route::any('orgmanager', 'orgmanagerController@orgmanager');
    Route::any('get_org', 'IndexController@get_org');
    Route::any('memployee', 'userController@memployee');
    Route::any('get_userbrow', 'userController@get_userbrow');
    Route::any('bm_add', 'orgmanagerController@bm_add');
    Route::any('del_select_dept', 'orgmanagerController@del_select_dept');
    Route::any('get_dept_byid', 'orgmanagerController@get_dept_byid');
    Route::any('bm_edit', 'orgmanagerController@bm_edit');
    Route::any('getnewip/{wd}', 'iptableController@getnewip');
//    Route::any('getwd', 'iptableController@getwd');

    Route::any('get_dept2', 'userController@get_dept2');
    Route::any('m_auth', 'userController@m_auth');
    Route::any('get_auth', 'userController@get_auth');
    Route::any('get_auth4', 'userController@get_auth4');
    Route::any('getauth2/{login_name}', 'userController@get_auth2');
    Route::any('yfqx_add', 'userController@yfqx_add');
    Route::any('del_yfqx_user', 'userController@del_yfqx_user');
    Route::any('yfqx_edit_update', 'userController@yfqx_edit_update');
    Route::any('get_employee_byid', 'userController@get_employee_byid');

    Route::any('get_jsdata', 'userController@get_jsdata');
    Route::any('addgroup', 'userController@addgroup');
    Route::any('del_jsdata', 'userController@del_jsdata');
    Route::any('updategroup', 'userController@updategroup');
    Route::any('get_group_byid', 'userController@get_group_byid');
    Route::any('getuser_js', 'userController@getuser_js');


    Route::any('get_zabbix', 'zabbixController@get_zabbix');
    Route::any('get1841_in', 'zabbixController@get1841_in');

    Route::any('get_sslist', 'ssglController@get_sslist');
    Route::any('ssdj', 'ssglController@ssdj');
    Route::any('savess', 'ssglController@savess');
    Route::any('delss', 'ssglController@delss');
    Route::any('getss', 'ssglController@getss');
});