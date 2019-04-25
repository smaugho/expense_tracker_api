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

Route::group([
//    'middleware' => 'api',
//    'prefix' => '/api'
], function () {

    // Public Route
    Route::post('/login', 'ApiController@login')->name('auth.login');
    Route::post('/register', 'UserController@register')->name('auth.register');

    Route::group([
        'middleware' => ['jwt.auth']
    ], function () {

        Route::post('/profile/edit', 'UserController@edit')->name('profile.edit');
        Route::post('/logout', 'ApiController@logout');

        Route::prefix('/expenses')->group(function () {

            Route::post('/list', 'ExpenseController@getList')->name('expense.list');
            Route::get('/details/{id}', 'ExpenseController@getData')->name('expense.details');

            Route::post('/create', 'ExpenseController@create')->name('expense.create');
            Route::post('/edit', 'ExpenseController@edit')->name('expense.edit');
            Route::post('/remove', 'ExpenseController@remove')->name('expense.remove');
        });

    });


});
