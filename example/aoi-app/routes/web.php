<?php

// use App\Events\HelloEvent;
use App\Helpers\Acl as HelpersAcl;
use Illuminate\Support\Facades\Route;

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
Route::get('/maintenance', function () {
    $acl = new HelpersAcl;
    $acl->maintenanceWeb();
    return view('maintenance');
});
Route::get('/', function(){
    return view('welcome');
});
Route::get('/send', function(){
    $text = date('Y-m-d H:i:s').' Hello baka chat';
    broadcast(new App\Events\HelloEvent($text));
});

Route::group(['middleware' => 'verify.user'], function () {
    // Route::get('/', 'App\Http\Controllers\LoginController@index')->name('home');
    Route::get('login', 'App\Http\Controllers\LoginController@index')->name('login');
    Route::post('login/auth', 'App\Http\Controllers\LoginController@auth')->name('login.auth');
});

Route::group(['middleware' => 'verify.login'], function () {
    Route::get('dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
    Route::get('logout', 'App\Http\Controllers\DashboardController@logout')->name('logout');
    Route::resource('privillage', 'App\Http\Controllers\PrivillageController');
    Route::resource('pm', 'App\Http\Controllers\PmController');
    Route::resource('pu', 'App\Http\Controllers\PuController');
    Route::resource('menu', 'App\Http\Controllers\MenuController');
    Route::resource('user', 'App\Http\Controllers\UserController');
    Route::resource('setting', 'App\Http\Controllers\SettingController');
});
