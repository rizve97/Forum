<?php

use App\Channel;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jquery',function() {
	return view('jquery');
});

Route::post('/ajaxRequest','NotificationController@jquery');

Auth::routes();
Route::group(['prefix' => 'forum'], function(){
	Route::resources([
		'channel' => 'ChannelController',
		'notification' => 'NotificationController',
		'problem' => 'ProblemController',
		'report' => 'ReportController',
		'solution' => 'SolutionController',
		'like' => 'LikeController',
		'achievement' => 'AchievementController',
	]);
});

Route::get('/home', 'HomeController@index')->name('home');
