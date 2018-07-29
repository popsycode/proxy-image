<?php
/**
 * Created by PhpStorm.
 * User: POPsy
 * Date: 29.07.2018
 * Time: 7:13
 */

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
Route::get('i-proxy.png', [
    'as' => 'i-proxy',
    'uses' => 'POPsy\ProxyImage\Controllers\ProxyImageController@get'
]);