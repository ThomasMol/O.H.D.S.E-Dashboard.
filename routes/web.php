<?php

/*login*/
Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@index']);
Route::get('/loguit', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::post('/login', 'Auth\LoginController@authenticate');

Route::middleware(['auth'])->group(function () {

    Route::get('/', 'HomeController@index');

    /*eigen gegevens */
    Route::get('/gegevens', 'GegevensController@index');
    Route::get('/gegevens/wijzig', 'GegevensController@edit');
    Route::patch('/gegevens', 'GegevensController@update');

    // TODO password reset, email change
    Route::post('/gegevens/wijziglogin', 'GegevensController@wijziglogin');


    // begroting
    Route::get('/begrotingen', 'BegrotingController@index')->middleware('admin');
    Route::get('/begroting/toevoegen', 'BegrotingController@create')->middleware('admin');
    Route::post('/begroting', 'BegrotingController@store')->middleware('admin');
    Route::get('/begroting/{bestuursjaar}', 'BegrotingController@show')->middleware('admin');
    Route::get('/begroting/{bestuursjaar}/wijzig', 'BegrotingController@edit')->middleware('admin');
    Route::patch('/begroting/{bestuursjaar}', 'BegrotingController@update')->middleware('admin');
    Route::delete('/begroting/{bestuursjaar}', 'BegrotingController@destroy')->middleware('admin');

    /*boetes*/
    Route::get('/boetes', 'BoetesController@index');
    Route::get('/boetes/toevoegen', 'BoetesController@create')->middleware('admin');
    Route::post('/boetes', 'BoetesController@store')->middleware('admin');
    Route::get('/boete/{boete}', 'BoetesController@show');
    Route::get('/boetes/{boete}/wijzig', 'BoetesController@edit')->middleware('admin');
    Route::patch('/boetes/{boete}', 'BoetesController@update')->middleware('admin');
    Route::delete('/boetes/{boete}', 'BoetesController@destroy')->middleware('admin');

    /*borrels*/
    Route::get('/borrels', 'BorrelsController@index');
    Route::get('/borrels/toevoegen', 'BorrelsController@create')->middleware('admin');
    Route::post('/borrels', 'BorrelsController@store')->middleware('admin');
    Route::get('/borrel/{borrel}', 'BorrelsController@show');
    Route::get('/borrels/{borrel}/wijzig', 'BorrelsController@edit')->middleware('admin');
    Route::patch('/borrels/{borrel}', 'BorrelsController@update')->middleware('admin');
    Route::delete('/borrels/{borrel}', 'BorrelsController@destroy')->middleware('admin');

    /*contributies*/
    Route::get('/contributies', 'ContributieController@index');
    Route::get('/contributies/toevoegen/{bestuursjaar}', 'ContributieController@create')->middleware('admin');
    Route::post('/contributies', 'ContributieController@store')->middleware('admin');
    Route::get('/contributie/{contributie}', 'ContributieController@show');
    Route::get('/contributies/{contributie}/wijzig/{bestuursjaar}', 'ContributieController@edit')->middleware('admin');
    Route::patch('/contributies/{contributie}', 'ContributieController@update')->middleware('admin');
    Route::delete('/contributies/{contributie}', 'ContributieController@destroy')->middleware('admin');

    /*declaraties*/
    Route::get('/declaraties', 'DeclaratiesController@index');
    Route::get('/declaraties/toevoegen', 'DeclaratiesController@create');
    Route::post('/declaraties', 'DeclaratiesController@store');
    Route::get('/declaratie/{declaratie}', 'DeclaratiesController@show');
    Route::get('/declaraties/{declaratie}/wijzig', 'DeclaratiesController@edit');
    Route::patch('/declaraties/{declaratie}', 'DeclaratiesController@update');
    Route::delete('/declaraties/{declaratie}', 'DeclaratiesController@destroy');

    /*leden*/
    Route::get('/leden', 'LedenController@index');
    Route::get('/leden/toevoegen', 'LedenController@create')->middleware('admin');
    Route::post('/leden', 'LedenController@store')->middleware('admin');
    Route::get('/lid/{lid}', 'LedenController@show');
    Route::get('/leden/{lid}/wijzig', 'LedenController@edit')->middleware('admin');
    Route::patch('/leden/{lid}', 'LedenController@update')->middleware('admin');
    Route::delete('/leden/{lid}', 'LedenController@destroy')->middleware('admin');

    /*transacties */
    Route::get('/transacties', 'TransactiesController@index');
    Route::get('/transacties/toevoegen', 'TransactiesController@create')->middleware('admin');
    Route::post('/transacties', 'TransactiesController@store')->middleware('admin');
    Route::get('/transactie/{transactie}', 'TransactiesController@show');
    Route::get('/transacties/{transactie}/wijzig', 'TransactiesController@edit')->middleware('admin');
    Route::patch('/transacties/{transactie}', 'TransactiesController@update')->middleware('admin');
    Route::delete('/transacties/{transactie}', 'TransactiesController@destroy')->middleware('admin');
    Route::get('/transacties/upload', 'TransactiesController@upload')->middleware('admin');
    Route::post('/transacties/upload', 'TransactiesController@parse')->middleware('admin');
    Route::post('/transacties/process', 'TransactiesController@process')->middleware('admin');

    /*uitgaven*/
    Route::get('/uitgaven', 'UitgavenController@index');
    Route::get('/uitgaven/toevoegen/{bestuursjaar}', 'UitgavenController@create')->middleware('admin');
    Route::post('/uitgaven', 'UitgavenController@store')->middleware('admin');
    Route::get('/uitgave/{uitgave}', 'UitgavenController@show');
    Route::get('/uitgaven/{uitgave}/wijzig/{bestuursjaar}', 'UitgavenController@edit')->middleware('admin');
    Route::patch('/uitgaven/{uitgave}', 'UitgavenController@update')->middleware('admin');
    Route::delete('/uitgaven/{uitgave}', 'UitgavenController@destroy')->middleware('admin');
});
