<?php

use App\Http\Controllers\CartoonController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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


Route::get('/', [CartoonController::class, 'index'])->name('home');
Route::post('/process', [CartoonController::class, 'process'])->name('process');

Auth::routes([
    'register/' => false, // Registration Routes...
    'reset/' => false, // Password Reset Routes...
    'verify/' => false, // Email Verification Routes...
]);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::put('/cartoons/updateData', [HomeController::class, 'updateData'])->name('updateData');
Route::put('/cartoons/editDataCartoon/{cartoon}', [CartoonController::class, 'editDataCartoon'])->name('editDataCartoon')->middleware('auth');
Route::delete('/cartoons/deleteCartoon/{cartoon}', [CartoonController::class, 'deleteCartoon'])->name('deleteCartoon')->middleware('auth');
Route::post('/cartoons/addCartoon', [CartoonController::class, 'addCartoon'])->name('addCartoon')->middleware('auth');
Route::put('/cartoons/editCartoonImage/{cartoon}', [CartoonController::class, 'editCartoonImage'])->name('editCartoonImage')->middleware('auth');
Route::delete('/cartoons/deleteSelectedCartoon/', [CartoonController::class, 'deleteSelectedCartoon'])->name('deleteSelectedCartoon')->middleware('auth');

Route::post('/cartoons/addCriteria', [CartoonController::class, 'addCriteria'])->name('addCriteria')->middleware('auth');
Route::put('/cartoons/editCriteria/{criteria}', [CartoonController::class, 'editCriteria'])->name('editCriteria')->middleware('auth');
Route::delete('/cartoons/deleteCriteria/{criteria}', [CartoonController::class, 'deleteCriteria'])->name('deleteCriteria')->middleware('auth');

Route::post('/cartoons/addCriteriaIndicator', [CartoonController::class, 'addCriteriaIndicator'])->name('addCriteriaIndicator')->middleware('auth');
Route::put('/cartoons/editCriteriaIndicator/{criteriaIndicator}', [CartoonController::class, 'editCriteriaIndicator'])->name('editCriteriaIndicator')->middleware('auth');
Route::delete('/cartoons/deleteCriteriaIndicator/{criteriaIndicator}', [CartoonController::class, 'deleteCriteriaIndicator'])->name('deleteCriteriaIndicator')->middleware('auth');
