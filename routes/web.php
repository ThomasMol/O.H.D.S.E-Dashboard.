<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Login en logout
Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@index']);
Route::get('/loguit', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::post('/login', 'Auth\LoginController@authenticate');

// Wachtwoord reset
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Ingelogde leden
Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index');

    // Lid gegevens
    Route::get('/gegevens', 'GegevensController@index');
    Route::get('/gegevens/wijzig', 'GegevensController@edit');
    Route::patch('/gegevens', 'GegevensController@update');
    Route::post('/gegevens/wijzig_wachtwoord', 'GegevensController@wijzig_wachtwoord');

    // Declaraties
    Route::get('/declaraties', 'DeclaratiesController@index');
    Route::get('/declaraties/toevoegen', 'DeclaratiesController@create');
    Route::post('/declaraties', 'DeclaratiesController@store');
    Route::get('/declaratie/{declaratie}', 'DeclaratiesController@show');
    Route::get('/declaraties/{declaratie}/wijzig', 'DeclaratiesController@edit');
    Route::patch('/declaraties/{declaratie}', 'DeclaratiesController@update');
    Route::delete('/declaraties/{declaratie}', 'DeclaratiesController@destroy');


    // Contributies
    Route::get('/contributies', 'ContributieController@index');;
    Route::get('/contributie/{contributie}', 'ContributieController@show');;


    // Kosten
    Route::get('/kosten', 'KostenController@index');
    Route::get('/kosten/{kosten}', 'KostenController@show');


    // Uitgave
    Route::get('/uitgaven', 'UitgavenController@index');
    Route::get('/uitgave/{uitgave}', 'UitgavenController@show');
});

// Ingelogd bestuur only
Route::middleware(['auth', 'admin'])->group(function () {

    // Begroting
    Route::get('/begrotingen', 'BegrotingController@index');
    Route::get('/begroting/toevoegen', 'BegrotingController@create');
    Route::post('/begroting', 'BegrotingController@store');
    Route::get('/begroting/{bestuursjaar}', 'BegrotingController@show');
    Route::get('/begroting/{bestuursjaar}/wijzig', 'BegrotingController@edit');
    Route::patch('/begroting/{bestuursjaar}', 'BegrotingController@update');
    Route::delete('/begroting/{bestuursjaar}', 'BegrotingController@destroy');
    Route::get('/begroting/downdload/financien', 'BegrotingController@download_financien');


    // Contributies
    Route::get('/contributies', 'ContributieController@index');;
    Route::get('/contributies/toevoegen/{bestuursjaar}', 'ContributieController@create');
    Route::post('/contributies', 'ContributieController@store');
    Route::get('/contributie/{contributie}', 'ContributieController@show');;
    Route::get('/contributies/{contributie}/wijzig/{bestuursjaar}', 'ContributieController@edit');
    Route::patch('/contributies/{contributie}', 'ContributieController@update');
    Route::delete('/contributies/{contributie}', 'ContributieController@destroy');


    // Instellingen
    Route::get('/instellingen', 'InstellingenController@index');
    Route::get('/instellingen/onverwijderlid/{lid}', 'InstellingenController@undeleteLid');
    Route::get('/instellingen/nieuwebegroting', 'InstellingenController@maakBegroting');

    // Kosten
    Route::get('/kosten', 'KostenController@index');
    Route::get('/kosten/toevoegen/{bestuursjaar}', 'KostenController@create');
    Route::post('/kosten', 'KostenController@store');
    Route::get('/kosten/{kosten}', 'KostenController@show');
    Route::get('/kosten/{kosten}/wijzig/{bestuursjaar}', 'KostenController@edit');
    Route::patch('/kosten/{kosten}', 'KostenController@update');
    Route::delete('/kosten/{kosten}', 'KostenController@destroy');

    // Leden
    Route::get('/leden', 'LedenController@index');
    Route::get('/leden/toevoegen', 'LedenController@create');
    Route::post('/leden', 'LedenController@store');
    Route::get('/lid/{lid}', 'LedenController@show');
    Route::get('/leden/{lid}/wijzig', 'LedenController@edit');
    Route::patch('/leden/{lid}', 'LedenController@update');
    Route::delete('/leden/{lid}', 'LedenController@destroy');
    Route::get('/leden/leden_bestand', 'LedenController@download_ledenbestand');
    Route::get('/leden/top5', 'LedenController@top_5');


    // Transacties
    Route::get('/transacties', 'TransactiesController@index');
    Route::get('/transacties/filter/{soort?}', 'TransactiesController@index');;
    Route::get('/transacties/toevoegen', 'TransactiesController@create');
    Route::post('/transacties', 'TransactiesController@store');
    Route::get('/transactie/{transactie}', 'TransactiesController@show');;
    Route::get('/transacties/{transactie}/wijzig', 'TransactiesController@edit');
    Route::patch('/transacties/{transactie}', 'TransactiesController@update');
    Route::delete('/transacties/{transactie}', 'TransactiesController@destroy');
    Route::get('/transacties/upload', 'TransactiesController@upload');
    Route::post('/transacties/upload', 'TransactiesController@parse');
    Route::post('/transacties/process', 'TransactiesController@process');

    // Uitgave
    Route::get('/uitgaven/toevoegen/{bestuursjaar}', 'UitgavenController@create');
    Route::post('/uitgaven', 'UitgavenController@store');
    Route::get('/uitgaven/{uitgave}/wijzig/{bestuursjaar}', 'UitgavenController@edit');
    Route::patch('/uitgaven/{uitgave}', 'UitgavenController@update');
    Route::delete('/uitgaven/{uitgave}', 'UitgavenController@destroy');
});
