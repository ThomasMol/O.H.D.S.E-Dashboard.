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

    Route::post('/contributies/toevoegen','ContributieController@insert_update_contributie')->middleware('admin');
    Route::post('/contributies/wijzig','ContributieController@insert_update_contributie')->middleware('admin');

    /*uitgaven*/
    Route::get('/uitgaven','UitgavenController@index');
    Route::get('/uitgaven/toevoegen','UitgavenController@toevoegen')->middleware('admin');
    Route::get('/uitgaven/wijzig/{id}','UitgavenController@wijzigen')->middleware('admin');
    Route::get('/uitgave/{id}', 'UitgavenController@uitgave');

    Route::post('/uitgaven/toevoegen','UitgavenController@insert_update_uitgave')->middleware('admin');
    Route::post('/uitgaven/wijzig','UitgavenController@insert_update_uitgave')->middleware('admin');

    /*declaraties*/
    Route::get('/declaraties','DeclaratiesController@index');
    Route::get('/declaratie/toevoegen','DeclaratiesController@toevoegen');
    Route::get('/declaratie/wijzig/{id}','DeclaratiesController@wijzigen');
    Route::get('/declaratie/{id}', 'DeclaratiesController@declaratie');
    Route::get('/declaratie/verwijder/{id}', 'DeclaratiesController@verwijderen');

    Route::post('/declaratie/toevoegen','DeclaratiesController@insert_update_declaratie');
    Route::post('/declaratie/wijzig','DeclaratiesController@insert_update_declaratie');


    /*transacties*/
    Route::get('/transacties', 'TransactiesController@index');
});


