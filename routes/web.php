<?php

/*login*/
Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@index']);
Route::get('/loguit',['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::post('/login' , 'Auth\LoginController@authenticate');

Route::middleware(['auth'])->group(function (){

    Route::get('/','HomeController@index')->middleware('auth');

    /*leden*/
    Route::get('/leden','LedenController@index');
    Route::get('/leden/toevoegen','LedenController@toevoegen')->middleware('admin');
    Route::get('/leden/wijzig/{id}','LedenController@wijzig')->middleware('admin');

    Route::post('/leden/toevoegen','LedenController@voeg_lid_toe')->middleware('admin');
    Route::post('/leden/wijzig/{id}','LedenController@wijzig_lid')->middleware('admin');

    /*eigen gegevens*/
    Route::get('/gegevens','GegevensController@index');
    Route::get('/gegevens/wijzig','GegevensController@wijzigform');

    Route::post('/gegevens/wijzig','GegevensController@wijzig');
    Route::post('/gegevens/wijziglogin','GegevensController@wijziglogin');

    /*contributies*/
    Route::get('/contributies','ContributieController@index');
    Route::get('/contributies/toevoegen','ContributieController@toevoegen')->middleware('admin');
    Route::get('/contributies/wijzig/{id}','ContributieController@wijzigen')->middleware('admin');
    Route::get('/contributie/{id}', 'ContributieController@contributie');

    Route::post('/contributies/toevoegen','ContributieController@voeg_contributie_toe')->middleware('admin');
    Route::post('/contributies/wijzig','ContributieController@wijzig_contributie')->middleware('admin');

    /*borrels*/
    Route::get('/borrels','BorrelsController@index');
    Route::get('/borrels/toevoegen','BorrelsController@toevoegen')->middleware('admin');
    Route::get('/borrels/wijzig/{id}','BorrelsController@wijzigen')->middleware('admin');
    Route::get('/borrel/{id}', 'BorrelsController@borrel');

    Route::post('/borrels/toevoegen','BorrelsController@voeg_borrel_toe')->middleware('admin');
    Route::post('/borrels/wijzig/{id}','BorrelsController@wijzig_borrel')->middleware('admin');

    /*declaraties*/
    Route::get('/declaraties','DeclaratiesController@index');
    Route::get('/declaratie/toevoegen','DeclaratiesController@toevoegen');
    Route::get('/declaratie/wijzig/{id}','DeclaratiesController@wijzigen');
    Route::get('/declaratie/{id}', 'DeclaratiesController@declaratie');
    Route::get('/declaratie/verwijder/{id}', 'DeclaratiesController@verwijderen');

    Route::post('/declaratie/toevoegen','DeclaratiesController@voeg_declaratie_toe');
    Route::post('/declaratie/wijzig/{id}','DeclaratiesController@wijzig_declaratie');


    /*transacties*/
    Route::get('/transacties', 'TransactiesController@index');
});


