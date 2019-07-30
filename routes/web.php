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

    Route::post('/leden/toevoegen','LedenController@insert_update_lid')->middleware('admin');
    Route::post('/leden/wijzig','LedenController@insert_update_lid')->middleware('admin');

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
    Route::get('/contributies/verwijder/{id}', 'ContributieController@verwijderen');

    /*uitgaven*/
    Route::get('/uitgaven','UitgavenController@index');
    Route::get('/uitgaven/toevoegen','UitgavenController@toevoegen')->middleware('admin');
    Route::get('/uitgaven/wijzig/{id}','UitgavenController@wijzigen')->middleware('admin');
    Route::get('/uitgave/{id}', 'UitgavenController@uitgave');
    Route::get('/uitgaven/verwijder/{id}', 'UitgavenController@verwijderen');

    Route::post('/uitgaven/toevoegen','UitgavenController@insert_update_uitgave')->middleware('admin');
    Route::post('/uitgaven/wijzig','UitgavenController@insert_update_uitgave')->middleware('admin');

    /*declaraties*/
    Route::get('/declaraties','DeclaratiesController@index');
    Route::get('/declaraties/toevoegen','DeclaratiesController@toevoegen');
    Route::get('/declaraties/wijzig/{id}','DeclaratiesController@wijzigen');
    Route::get('/declaraties/{id}', 'DeclaratiesController@declaratie');
    Route::get('/declaraties/verwijder/{id}', 'DeclaratiesController@verwijderen');

    Route::post('/declaraties/toevoegen','DeclaratiesController@insert_update_declaratie');
    Route::post('/declaraties/wijzig','DeclaratiesController@insert_update_declaratie');


    /*transacties*/
    Route::get('/transacties', 'TransactiesController@index');
});


