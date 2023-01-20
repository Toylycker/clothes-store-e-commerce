<?php

use App\Http\Controllers\admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\admin\Auth\RegisteredUserController;
use App\Http\Controllers\front\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\OutfitController;
use App\Http\Controllers\front\CommentController;
use App\Http\Controllers\front\SellerController;
use App\Http\Controllers\front\OrderController;
use App\Http\Controllers\front\ShopCartController;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;



Route::controller(OutfitController::class)->group(function () {
    Route::get('/outfits/home', 'index')->name('outfits.home');
    Route::get('/outfits/home/variations', 'variations')->name('variations');
    Route::get('/outfits/home/variations/choose', 'variation_choosing')->name('variationchoosing');
    Route::get('/outfit/{outfit_id}/show', 'show')->name('outfit.show');
    Route::post('/outfit/{outfit_id}/show','show')->name('outfit.show');
});

Route::controller(ShopCartController::class)->middleware('auth')->group(function () {
    Route::get('/shopcart', 'index')->name('shopcart');
    Route::get('/additem/{id}', 'addItem')->name('additem');

});


































Route::middleware('auth')->controller(SellerController::class)->name('seller.')->prefix('seller')->group(function () {
    Route::get('/register', 'create')->name('register');
    Route::post('/store', 'store')->name('store');

});
Route::middleware(['auth', 'seller'])->controller(SellerController::class)->name('seller.')->prefix('seller')->group(function () {
    Route::get('/outfit/my_outfits', 'my_outfits')->name('outfit.my_outfits');

});