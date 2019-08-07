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

    /*declaraties*/
    Route::get('/declaraties','DeclaratiesController@index');
    Route::get('/declaraties/toevoegen','DeclaratiesController@create');
    Route::post('/declaraties','DeclaratiesController@store');
    Route::get('/declaratie/{declaratie}','DeclaratiesController@show');
    Route::get('/declaraties/{declaratie}/wijzig','DeclaratiesController@edit');
    Route::patch('/declaraties/{declaratie}', 'DeclaratiesController@update');
    Route::delete('/declaraties/{declaratie}', 'DeclaratiesController@destroy');

    /*uitgaven*/
    Route::get('/uitgaven','UitgavenController@index');
    Route::get('/uitgaven/toevoegen','UitgavenController@create')->middleware('admin');
    Route::post('/uitgaven','UitgavenController@store')->middleware('admin');
    Route::get('/uitgave/{uitgave}', 'UitgavenController@show');
    Route::get('/uitgaven/{uitgave}/wijzig','UitgavenController@edit')->middleware('admin');
    Route::patch('/uitgaven/{uitgave}','UitgavenController@update')->middleware('admin');
    Route::delete('/uitgaven/{uitgave}', 'UitgavenController@destroy')->middleware('admin');



    /*transacties*/
    Route::get('/transacties', 'TransactiesController@index');
});


