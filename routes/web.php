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
Route::get('/', 'GitHubController@index')->name('main');
Route::post('/', 'GitHubController@getPullRequests');
Route::get('/token', 'GitHubController@setToken');
Route::get('/login', 'GitHubController@authenticate');
Route::get('/logout', 'GitHubController@logout');
Route::get('/{owner}/{repo}/update-status/{pullRequestNumber}', 'GitHubController@updatePullRequestStatus');

