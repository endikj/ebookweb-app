<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembacaEbookController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[PembacaEbookController::class, 'index'])->name('/')->middleware('guest');

Route::controller(LoginController::class)->group(function(){
    Route::get('login', 'index')->name('login')->middleware('guest');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
});


Route::group(['middleware' => ['auth']], function(){
    Route::group(['middleware' => ['checkUserRole:1,2']], function(){
        Route::resource('dashboard',DashboardController::class)->names([
            'index' => 'dashboard.index',
        ]);
        Route::resource('ebook',EbookController::class)->names([
            'index' => 'ebook.index',
        ]);
        Route::resource('kategori',KategoriController::class)->names([
            'index' => 'kategori.index',
        ]);
    });
    
    Route::group(['middleware' => ['checkUserRole:3']], function(){
        Route::resource('home',PembacaEbookController::class);
    });
            // 'create' => 'superadmin.create',
            // 'store' => 'superadmin.store',
            // 'show' => 'superadmin.show',
            // 'edit' => 'superadmin.edit',
            // 'update' => 'superadmin.update',
            // 'destroy' => 'superadmin.destroy',
});


