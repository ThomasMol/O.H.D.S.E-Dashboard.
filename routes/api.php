<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Login en logout
Route::post('/login','Auth\LoginController@authenticate');
// TODO test:
//Route::post('/logout','Auth\LoginController@logout');

// Ingelogde leden
Route::middleware(['auth:api'])->group(function () {
    Route::get('/', 'HomeController@index');

     // Uitgave
     Route::get('/uitgaven', 'UitgavenController@index');
     Route::get('/uitgave/{uitgave}', 'UitgavenController@show');
});

// Ingelogd bestuur only
Route::middleware(['auth:api','admin'])->group(function () {

});


// Test route
Route::get('/test','HomeController@test');
