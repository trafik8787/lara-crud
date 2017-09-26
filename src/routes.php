<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 11.08.2017
 * Time: 15:25
 */


Route::group(['prefix'=>config('lara-config.url_group'),'namespace' => 'Trafik8787\LaraCrud\Controllers', 'middleware' => ['web']], function() {

    //Route::get('qwe', ['as' => 'qwe','uses' => 'AdminController@showProfile']);

    Route::get('{adminModel}', [
        'as'   => 'model.showTable',
        'uses' => 'AdminController@showTable',
    ]);

    Route::post('{adminModel}', [
        'as'   => 'model.ajax.dispaly.table',
        'uses' => 'AdminController@inlineTable',
    ]);

    Route::get('{adminModel}/{adminModelId}/edit', [
        'as'   => 'model.edit',
        'uses' => 'AdminController@showEdit',
    ]);


    Route::patch('{adminModel}/{adminModelId}/{newAction}', [
        'as'   => 'model.postNewAction',
        'uses' => 'AdminController@postNewAction',
    ]);

    Route::patch('{adminModel}/{adminModelId}/edit', [
        'as'   => 'model.update',
        'uses' => 'AdminController@postUpdate',
    ]);

    Route::get('{adminModel}/create', [
        'as'   => 'model.create',
        'uses' => 'AdminController@showCreate',
    ]);

    Route::post('{adminModel}/create', [
        'as'   => 'model.store',
        'uses' => 'AdminController@postStore',
    ]);


    Route::delete('{adminModel}/{adminModelId}/delete', [
        'as'   => 'model.delete',
        'middleware' => ['web'],
        'uses' => 'AdminController@deleteDelete',
    ]);
});

//Route::namespace('Trafik8787\LaraCrud\Controllers\Admin')->group(function () {
//    Route::get('qwe', ['as' => 'qwe','uses' => 'AdminController@showProfile']);
//});

//Route::prefix('admin')->group(function () {
//    Route::get('qwe', 'Trafik8787\LaraCrud\Controllers\Admin\AdminController@showProfile');
//});