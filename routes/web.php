<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\UserController;

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
Route::get('/login',[DefaultController::class,'login'])->name('login');
Route::post('/login',[DefaultController::class,'loginAttempt'])->name('loginAttempt');
Route::get('/logout',[DefaultController::class,'logout'])->name('logout')->middleware('isLogin');

Route::get('/',[DefaultController::class,'index'])->name('admin.dashboard')->middleware('isLogin')->middleware('isAdmin');
Route::get('/tanks',[DefaultController::class,'tankDetail'])->name('admin.tanks')->middleware('isLogin')->middleware('isAdmin');
Route::get('/tankfilling/{id}',[DefaultController::class,'tankFilling'])->name('admin.filling')->middleware('isLogin')->middleware('isAdmin');
Route::get('/tankunload/{id}',[DefaultController::class,'tankUnload'])->name('admin.unload')->middleware('isLogin')->middleware('isAdmin');
Route::post('/tankunload/{id}',[DefaultController::class,'tankUnloadRequest'])->name('admin.unload.post')->middleware('isLogin')->middleware('isAdmin');

Route::get('/settings',[DefaultController::class,'settings'])->name('admin.settings')->middleware('isLogin')->middleware('isAdmin');
Route::post('/settings/update',[DefaultController::class,'settingsUpdate'])->name('admin.settings.update')->middleware('isLogin')->middleware('isAdmin');
Route::post('/settings/price/update',[DefaultController::class,'priceUpdate'])->name('admin.price.update')->middleware('isLogin')->middleware('isAdmin');
Route::get('/report',[DefaultController::class,'reportView'])->name('admin.report')->middleware('isLogin')->middleware('isAdmin');

Route::post('/tankfilling/{id}',[DefaultController::class,'tankFillingRequest'])->name('admin.filling.post')->middleware('isLogin')->middleware('isAdmin');
Route::get('/user-management',[DefaultController::class,'userManagement'])->name('admin.users')->middleware('isLogin')->middleware('isAdmin');
Route::post('/user-management',[DefaultController::class,'userRegisterRequest'])->name('admin.user.register')->middleware('isLogin')->middleware('isAdmin');
Route::get('/user/delete/{id}',[DefaultController::class,'userDelete'])->name('admin.user.delete')->middleware('isLogin')->middleware('isAdmin');
Route::get('/user/edit/{id}',[DefaultController::class,'userEdit'])->name('admin.user.edit')->middleware('isLogin')->middleware('isAdmin');
Route::post('/user/edit/{id}',[DefaultController::class,'userEditaction'])->name('admin.user.edit.action')->middleware('isLogin')->middleware('isAdmin');

Route::get('/user/dashboard',[UserController::class,'index'])->name('user.dashboard')->middleware('isLogin');
Route::post('/user/sale',[UserController::class,'makeSale'])->name('user.sale')->middleware('isLogin');
