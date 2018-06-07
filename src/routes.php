<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 11.08.2017
 * Time: 15:25
 */


Route::group(['prefix' => config('lara-config.url_group'), 'namespace' => 'Trafik8787\LaraCrud\Controllers', 'middleware' => config('lara-config.middleware')], function () {

    Route::get('', ['as' => 'Dashboard', 'uses' => 'AdminController@getDashboard']);


    Route::get('{adminModel}', [
        'as' => 'model.showTable',
        'uses' => 'AdminController@showTable',
    ]);

    Route::post('{adminModel}', [
        'as' => 'model.ajax.dispaly.table',
        'uses' => 'AdminController@inlineTable',
    ]);

    Route::get('{adminModel}/{adminModelId}/edit', [
        'as' => 'model.edit',
        'uses' => 'AdminController@showEdit',
    ]);


    Route::patch('{adminModel}/{adminModelId}/{newAction}/action', [
        'as' => 'model.postNewAction',
        'uses' => 'AdminController@postNewAction',
    ]);

    Route::patch('{adminModel}/{adminModelId}/edit', [
        'as' => 'model.update',
        'uses' => 'AdminController@postUpdate',
    ]);

    Route::get('{adminModel}/create', [
        'as' => 'model.create',
        'uses' => 'AdminController@showCreate',
    ]);

    Route::post('{adminModel}/create', [
        'as' => 'model.store',
        'uses' => 'AdminController@postStore',
    ]);


    Route::delete('{adminModel}/{adminModelId}/delete', [
        'as' => 'model.delete',
        'middleware' => ['web'],
        'uses' => 'AdminController@deleteDelete',
    ]);
});
