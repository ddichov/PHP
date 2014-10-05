<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::get('/', 'HomeController@showLogin');
Route::get('login', 'HomeController@showLogin');
Route::post('login', 'HomeController@doLogin');
Route::get('registration', 'HomeController@showRegistration');
Route::post('registration', 'HomeController@doRegistration');
Route::get('logout', 'HomeController@logout');

Route::get('auction', 'AuctionController@getActualAuctions');


Route::group(array('before' => 'auth'), function() {

    Route::get('users', 'UserController@getIndex');
    Route::any('users/add', 'UserController@getIndex');

//    Route::get('auction', 'AuctionController@getAuction');
    Route::any('auction/{id?}', 'AuctionController@getAuction');
    
    Route::post('add/auction', 'AuctionController@addAuction'); //
    Route::get('add/auction', 'AuctionController@showAddAuction'); //
    Route::get('my/auction', 'UserController@myAuctions'); //
    
    Route::post('bet/auction/{id?}', 'AuctionController@betAuction'); //
    Route::get('auction/{id}/{details?}', 'AuctionController@showAuctionFullInfo'); //
    
    Route::post('comment/auction/{id?}', 'AuctionController@commentAuction'); //
//    Route::get('comment/auction/{id}', 'AuctionController@showAuctionFullInfo'); //
    
    Route::post('vote/auction/{id?}', 'AuctionController@voteAuction'); //
//    Route::get('comment/auction/{id}', 'AuctionController@showAuctionFullInfo'); //
});

//Route::get('users', array('before' => 'auth', function(){ }));

/*
 * Route::get('/', function()
 * {
 * 	return View::make('hello');
 * }); 
 */




