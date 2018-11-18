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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('user')->group(function () {

    Route::post('/registration', 'AuthController@newUserWizard');
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');

});

Route::middleware(['jwt.auth'])->prefix('employee')->group(function () {

    Route::get('/', 'EmployeeController@index');
    Route::get('/show/{id}', 'EmployeeController@show');
    Route::post('/create', 'EmployeeController@create');
    Route::post('/update/{id}', 'EmployeeController@update');
    Route::post('/delete/{id}', 'EmployeeController@delete');

});

Route::middleware(['jwt.auth'])->prefix('salary')->group(function () {

    Route::get('/', 'SalaryController@index');
    Route::get('/show/{id}', 'SalaryController@show');
    Route::post('/create', 'SalaryController@create');
    Route::post('/update/{id}', 'SalaryController@update');
    Route::post('/delete/{id}', 'SalaryController@delete');

});