<?php

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

Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');


Route::get('/console', 'HomeController@sql_console')->name('sql_console');
Route::post('/console', 'HomeController@post_sql_console')->name('post_sql_console');

Route::post('/create/database', 'HomeController@post_create_database')->name('post_create_database');
Route::post('/delete/database', 'HomeController@post_delete_database')->name('post_delete_database');

Route::get('/create/table', 'HomeController@create_table')->name('create_table');
Route::get('/edit/table/{name}', 'HomeController@edit_table')->name('edit_table');
Route::post('/create/table', 'HomeController@post_create_table')->name('post_create_table');
Route::post('/edit/table', 'HomeController@post_edit_table')->name('post_edit_table');
Route::post('/delete/table', 'HomeController@post_delete_table')->name('post_delete_table');


Route::get('/create/view', 'HomeController@create_view')->name('create_view');
Route::get('/edit/view/{name}', 'HomeController@edit_view')->name('edit_view');
Route::post('/create/view/', 'HomeController@post_create_view')->name('post_create_view');
Route::post('/edit/view', 'HomeController@post_edit_view')->name('post_edit_view');
Route::post('/delete/view', 'HomeController@post_delete_view')->name('post_delete_view');


Route::get('/create/index', 'HomeController@create_index')->name('create_index');
Route::get('/edit/index/{name}', 'HomeController@edit_index')->name('edit_index');
Route::post('/create/index/', 'HomeController@post_create_index')->name('post_create_index');
Route::post('/edit/index', 'HomeController@post_edit_index')->name('post_edit_index');
Route::post('/delete/index', 'HomeController@post_delete_index')->name('post_delete_index');


Route::get('/create/contraint', 'HomeController@create_constraint')->name('create_constraint');
Route::get('/edit/contraint/{name}', 'HomeController@edit_constraint')->name('edit_constraint');
Route::post('/create/primary', 'HomeController@post_primary_key')->name('post_primary_key');
Route::post('/create/foreign', 'HomeController@post_foreign_key')->name('post_foreign_key');
Route::post('/edit/primary', 'HomeController@post_edit_primary')->name('post_edit_primary');
Route::post('/edit/foreign', 'HomeController@post_edit_foreign')->name('post_edit_foreign');
Route::post('/delete/primary', 'HomeController@post_delete_primary_key')->name('post_delete_primary_key');
Route::post('/delete/foreign', 'HomeController@post_delete_foreign_key')->name('post_delete_foreign_key');


Route::get('/create/trigger', 'HomeController@create_trigger')->name('create_trigger');
Route::get('/edit/trigger/{name}', 'HomeController@edit_trigger')->name('edit_trigger');
Route::post('/create/trigger', 'HomeController@post_create_trigger')->name('post_create_trigger');


Route::get('/create/sequence', 'HomeController@create_sequence')->name('create_sequence');
Route::get('/edit/sequence/{name}', 'HomeController@edit_sequence')->name('edit_sequence');
Route::post('/create/sequence', 'HomeController@post_create_sequence')->name('post_create_sequence');
Route::post('/edit/sequence', 'HomeController@post_edit_sequence')->name('post_edit_sequence');
Route::post('/delete/sequence', 'HomeController@post_delete_sequence')->name('post_delete_sequence');


Route::get('/create/procedure', 'HomeController@create_procedure')->name('create_procedure');
Route::get('/edit/procedure/{name}', 'HomeController@edit_procedure')->name('edit_procedure');
Route::post('/create/procedure', 'HomeController@post_create_procedure')->name('post_create_procedure');
Route::post('/edit/procedure', 'HomeController@post_edit_procedure')->name('post_edit_procedure');
Route::post('/delete/procedure', 'HomeController@post_delete_procedure')->name('post_delete_procedure');
