<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/home/{locale}', [ApiController::class, 'home'])->name('api.home');
Route::get('part-two/{locale}', [ApiController::class, 'categories'])->name('api.categories');
Route::post('contact-post', [ApiController::class, 'ContactStore'])->name('contact.store');
Route::get('page/{id}', [ApiController::class, 'showPage'])->name('api.showPage');