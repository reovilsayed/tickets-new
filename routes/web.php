<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [PagesController::class, 'home'])->name('index');
Route::get('event-details', [PagesController::class, 'event_details'])->name('event_details');
Route::get('event-tickets', [PagesController::class, 'event_tickets'])->name('event_tickets');
Route::get('event-checkout', [PagesController::class, 'event_checkout'])->name('event_checkout');
Route::get('event-speaker', [PagesController::class, 'event_speaker'])->name('event_speaker');
Route::get('contact', [PagesController::class, 'contact'])->name('contact');
Route::get('about', [PagesController::class, 'about'])->name('about');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
