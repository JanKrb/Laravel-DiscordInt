<?php

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

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Auth::routes();

// Dashboard
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);

	// Profile Routes
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::post('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::post('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

    // Temp Routes
	Route::get('map', function () {return view('pages.maps');})->name('map');
	Route::get('icons', function () {return view('pages.icons');})->name('icons');
	Route::get('table-list', function () {return view('pages.tables');})->name('table');

    // Roles Routes
    Route::get('roles', ['as' => 'roles.view', 'uses' => 'App\Http\Controllers\RoleController@view']);
    Route::put('roles', ['as' => 'roles.add', 'uses' => 'App\Http\Controllers\RoleController@addRole']);
    Route::patch('roles', ['as' => 'roles.edit', 'uses' => 'App\Http\Controllers\RoleController@editRoles']);
    Route::delete('roles', ['as' => 'roles.delete', 'uses' => 'App\Http\Controllers\RoleController@deleteRoles']);

    Route::get('roles/{roleid}/permissions', ['as' => 'roles.view.perms', 'uses' => 'App\Http\Controllers\RoleController@viewPermissions']);
    Route::put('roles/{roleid}/permissions', ['as' => 'roles.perms.add', 'uses' => 'App\Http\Controllers\RoleController@addPermissions']);
    Route::patch('roles/{roleid}/permissions', ['as' => 'roles.perms.edit', 'uses' => 'App\Http\Controllers\RoleController@editPermissions']);
    Route::delete('roles/{roleid}/permissions', ['as' => 'roles.perms.delete', 'uses' => 'App\Http\Controllers\RoleController@deletePermissions']);

    // Discord

    Route::get('{provider}/auth', ['as' => 'provider.login', 'uses' => 'App\Http\Controllers\SocialiteController@auth']);
    Route::get('{provider}/unauth', ['as' => 'provider.unauth', 'uses' => 'App\Http\Controllers\SocialiteController@unauth']);
    Route::get('{provider}/callback', ['as' => 'provider.callback', 'uses' => 'App\Http\Controllers\SocialiteController@callback']);
});

/* Impress & Privacy */

Route::get('/impress', function () {
    return view('legal.impress');
})->name('impress');
Route::get('/privacy', function () {
    return view('legal.privacy');
})->name('privacy');
