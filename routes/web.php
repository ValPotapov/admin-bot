<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::group(['middleware' => ['auth', 'verified']], function (){
    Route::resource('salons', 'SalonController');

    Route::resource('reports', 'ReportController');

    Route::resource('users', 'UserController');

    Route::get('/', 'IndexController@index');
});



require __DIR__.'/auth.php';
