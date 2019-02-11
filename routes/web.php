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

    /*activiteiten*/
    Route::get('/activiteiten','ActiviteitenController@index');
    Route::get('/activiteiten/toevoegen','ActiviteitenController@toevoegen')->middleware('admin');
    Route::get('/activiteiten/wijzig/{id}','ActiviteitenController@wijzigen')->middleware('admin');
    Route::get('/activiteit/{id}', 'ActiviteitenController@activiteit');

    Route::post('/activiteiten/toevoegen','ActiviteitenController@voeg_activiteit_toe')->middleware('admin');
    Route::post('/activiteiten/wijzig/{id}','ActiviteitenController@wijzig_activiteit')->middleware('admin');

    /*borrels*/
    Route::get('/borrels','BorrelsController@index');
    Route::get('/borrels/toevoegen','BorrelsController@toevoegen')->middleware('admin');
    Route::get('/borrels/wijzig/{id}','BorrelsController@wijzigen')->middleware('admin');
    Route::get('/borrel/{id}', 'BorrelsController@borrel');

    Route::post('/borrels/toevoegen','BorrelsController@voeg_borrel_toe')->middleware('admin');
    Route::post('/borrels/wijzig/{id}','BorrelsController@wijzig_borrel')->middleware('admin');

    /*declaraties*/
    Route::get('/declaraties','DeclaratiesController@index');
    Route::get('/declaraties/toevoegen','DeclaratiesController@toevoegen');
    Route::get('/declaraties/wijzig/{id}','DeclaratiesController@wijzigen');
    Route::get('/declaratie/{id}', 'DeclaratiesController@declaratie');

    Route::post('/declaraties/toevoegen','DeclaratiesController@voeg_declaratie_toe');
    Route::post('/declaraties/wijzig/{id}','DeclaratiesController@wijzig_declaratie');


    /*transacties*/
    Route::get('/transacties', 'TransactiesController@index');
});


