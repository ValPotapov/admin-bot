<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('/export/reports/{fileName}/',function (\Illuminate\Http\Request $request, $fileName){
    $secure = $request->get('secure');
    if($secure == md5('desu'.$fileName)) {
        return Storage::disk('local')->get($fileName);
    }else{
        echo 'security check error';
    }
});

Route::group(['middleware' => ['auth', 'verified']], function (){
    Route::resource('salons', 'SalonController');

    Route::resource('reports', 'ReportController');

    Route::post('reports_updates/{id}', 'ReportController@update')->name('reports.update.images');

    Route::resource('users', 'UserController');

    Route::resource('sources', 'SourceController');

    Route::resource('expenses', 'ExpensesController');
    Route::resource('expensesTypes', 'ExpensesTypesController');
    Route::resource('contractors', 'ContractorsController');

    Route::get('getSources/{salon_id}', 'SourceController@getSources')->name('getSources');

    Route::get('/', 'IndexController@index');
});



require __DIR__.'/auth.php';
