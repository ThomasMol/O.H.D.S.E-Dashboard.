<?php

/*login*/
Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@index']);
Route::get('/loguit',['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::post('/login' , 'Auth\LoginController@authenticate');

Route::middleware(['auth'])->group(function (){

    Route::get('/','HomeController@index');

    /*leden*/
    Route::get('/leden','LedenController@index');
    Route::get('/lid/{id}','LedenController@lid');
    Route::get('/leden/toevoegen','LedenController@toevoegen')->middleware('admin');
    Route::get('/leden/wijzig/{id}','LedenController@wijzig')->middleware('admin');
    Route::get('/leden/verwijder/{id}','LedenController@verwijder')->middleware('admin');

    Route::post('/leden/toevoegen','LedenController@insert_update_lid')->middleware('admin');
    Route::post('/leden/wijzig','LedenController@insert_update_lid')->middleware('admin');

    /*eigen gegevens*/
    Route::get('/gegevens','GegevensController@index');
    Route::get('/gegevens/wijzig','GegevensController@wijzigform');

    Route::post('/gegevens/wijzig','GegevensController@wijzig');
    Route::post('/gegevens/wijziglogin','GegevensController@wijziglogin');

    /*contributies*/
    Route::get('/contributies','ContributieController@index');
    Route::get('/contributies/toevoegen','ContributieController@create')->middleware('admin');
    Route::post('/contributies','ContributieController@store')->middleware('admin');
    Route::get('/contributie/{contributie}', 'ContributieController@show');
    Route::get('/contributies/{contributie}/wijzig','ContributieController@edit')->middleware('admin');
    Route::patch('/contributies/{contributie}','ContributieController@update')->middleware('admin');
    Route::delete('/contributies/{contributie}', 'ContributieController@destroy')->middleware('admin');


    /*uitgaven*/
    Route::get('/uitgaven','UitgavenController@index');
    Route::get('/uitgaven/toevoegen','UitgavenController@toevoegen')->middleware('admin');
    Route::get('/uitgaven/wijzig/{id}','UitgavenController@wijzigen')->middleware('admin');
    Route::get('/uitgave/{id}', 'UitgavenController@uitgave');
    Route::get('/uitgaven/verwijder/{id}', 'UitgavenController@verwijderen')->middleware('admin');

    Route::post('/uitgaven/toevoegen','UitgavenController@insert_update_uitgave')->middleware('admin');
    Route::post('/uitgaven/wijzig','UitgavenController@insert_update_uitgave')->middleware('admin');

    /*declaraties*/
    Route::get('/declaraties','DeclaratiesController@index');
    Route::get('/declaraties/toevoegen','DeclaratiesController@toevoegen');
    Route::get('/declaraties/wijzig/{id}','DeclaratiesController@wijzigen');
    Route::get('/declaratie/{id}', 'DeclaratiesController@declaratie');
    Route::get('/declaraties/verwijder/{id}', 'DeclaratiesController@verwijderen');

    Route::post('/declaraties/toevoegen','DeclaratiesController@insert_update_declaratie');
    Route::post('/declaraties/wijzig','DeclaratiesController@insert_update_declaratie');

    /*transacties*/
    Route::get('/transacties', 'TransactiesController@index');
});


