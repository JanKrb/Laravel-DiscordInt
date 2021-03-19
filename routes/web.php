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

    // Projects
    Route::get('projects', ['as' => 'projects.view', 'uses' => 'App\Http\Controllers\ProjectController@view']);
    Route::put('projects', ['as' => 'projects.create', 'uses' => 'App\Http\Controllers\ProjectController@createProject']);
    Route::patch('projects', ['as' => 'projects.edit', 'uses' => 'App\Http\Controllers\ProjectController@editProject']);
    Route::delete('projects', ['as' => 'projects.delete', 'uses' => 'App\Http\Controllers\ProjectController@deleteProject']);

    Route::get('project/{projectid}', ['as' => 'project.view', 'uses' => 'App\Http\Controllers\ProjectController@viewDetails']);
    Route::put('project/{projectid}/leader', ['as' => 'project.leader.add', 'uses' => 'App\Http\Controllers\ProjectController@addLeader']);
    Route::delete('project/{projectid}/leader', ['as' => 'project.leader.delete', 'uses' => 'App\Http\Controllers\ProjectController@deleteLeader']);
    Route::put('project/{projectid}/participant', ['as' => 'project.participant.add', 'uses' => 'App\Http\Controllers\ProjectController@addParticipant']);
    Route::delete('project/{projectid}/participant', ['as' => 'project.participant.delete', 'uses' => 'App\Http\Controllers\ProjectController@deleteParticipant']);
    Route::get('project/{projectid}/list', ['as' => 'project.view.list', 'uses' => 'App\Http\Controllers\BoardController@viewList']);
    Route::get('project/{projectid}/kanban', ['as' => 'project.view.kanban', 'uses' => 'App\Http\Controllers\BoardController@viewKanban']);
    Route::get('project/{projectid}/detail/{taskid}', ['as' => 'project.view.details', 'uses' => 'App\Http\Controllers\BoardController@viewDetail']);
    Route::put('project/{projectid}/detail/{taskid}', ['as' => 'project.view.answer', 'uses' => 'App\Http\Controllers\BoardController@answerTask']);
    Route::put('project/{projectid}/detail/{taskid}/participant', ['as' => 'project.task.addParticipant', 'uses' => 'App\Http\Controllers\BoardController@addParticipant']);
    Route::delete('project/{projectid}/detail/{taskid}/participant', ['as' => 'project.task.deleteParticipant', 'uses' => 'App\Http\Controllers\BoardController@deleteParticipant']);
    Route::patch('project/{projectid}/detail/{taskid}/tags', ['as' => 'project.task.updateStatus', 'uses' => 'App\Http\Controllers\BoardController@updateStatus']);
});

/* Impress & Privacy */

Route::get('/impress', function () {
    return view('legal.impress');
})->name('impress');
Route::get('/privacy', function () {
    return view('legal.privacy');
})->name('privacy');
