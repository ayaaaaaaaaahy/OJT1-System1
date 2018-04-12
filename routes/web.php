<?php

/*
|--------------------------------------------------------------------------
| Auth ---- Functions and Render
|--------------------------------------------------------------------------
*/
//all auth routes
Auth::routes();

/*
|--------------------------------------------------------------------------
| Admin and User Dashboard ---- Render
|--------------------------------------------------------------------------
*/
//admin and user dashboard render
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');

/*
|--------------------------------------------------------------------------
| Admin Side ---- Functions
|--------------------------------------------------------------------------
*/
//admin accept and decline documents
Route::post('/acceptdoc', 'UController@acceptdoc')->name('acceptdoc');
//admin upload documents
Route::get('/upload', 'AUDController@index')->name('upload');
Route::post('/upload', 'AUDController@upload')->name('upload');
//admin edit & delete documents
Route::get('/trash', 'ATController@index')->name('editdelete');
Route::post('/trashDocu', 'ATController@trashDocu')->name('trashDocu');   
Route::post('/deleteDocu', 'ATController@deleteDocu')->name('deleteDocu');     
Route::post('/recoverDocu', 'ATController@recoverDocu')->name('recoverDocu');           
Route::post('/deleteajax', 'AUDController@deleteajax');
Route::post('/editajax', 'AUDController@editajax');
//admin accept users
Route::get('/acceptuser', 'AAUController@index')->name('acceptuser');
Route::post('/acceptuser', 'AAUController@accept')->name('acceptuser');
Route::post('/AAUinfo', 'AAUController@userinfoajax');
//admin disable and re-enable users
Route::get('/disableuser', 'ADUController@index')->name('disableuser');
Route::post('/disableuser', 'ADUController@disable')->name('disableuser');
Route::post('/ADUinfo', 'ADUController@userinfoajax');
//admin history
Route::get('/adocumenthistory', 'AHController@documenthistory')->name('adocumenthistory');
Route::get('/auserhistory', 'AHController@userhistory')->name('auserhistory');

Route::post('/printPDF', 'APDFController@print')->name('printPDF');


/*
|--------------------------------------------------------------------------
| User Side ---- Functions
|--------------------------------------------------------------------------
*/
//admin history
Route::get('/documenthistory', 'UHController@documenthistory')->name('udocumenthistory');
