<?php

use App\Http\Controllers\admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\admin\Auth\RegisteredUserController;
use App\Http\Controllers\front\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\OutfitController;
use App\Http\Controllers\front\CommentController;
use App\Http\Controllers\front\ChatController;
use App\Http\Controllers\front\SellerController;
use App\Http\Controllers\front\OrderController;
use App\Http\Controllers\front\ShopCartController;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;



Route::controller(OutfitController::class)->group(function () {
    Route::get('/outfits/home', 'index')->name('outfits.home');
    Route::get('/', 'index')->name('outfits.home');
    Route::get('/outfits/home/variations', 'variations')->name('variations');
    Route::get('/outfits/home/variations/choose', 'variation_choosing')->name('variationchoosing');
    Route::get('/outfit/{outfit_id}/show', 'show')->name('outfit.show');
    Route::post('/outfit/{outfit_id}/show','show')->name('outfit.show');
});

Route::controller(ShopCartController::class)->middleware('auth')->group(function () {
    Route::post('/additem/{id}', 'addItem')->name('additem');
    Route::get('/shopcart', 'index')->name('shopcart');
    Route::delete('/shopcart/delete/{id}', 'destroy')->name('shopcart.delete');
    Route::post('/updatequantity/{itemid}/{quantity}', 'updateQuantity')->name('updatequantity');
    Route::post('/setorder', 'setOrder')->name('setorder');
});

Route::controller(OrderController::class)->middleware('auth')->group(function () {
    Route::get('/orders', 'index')->name('orders');
});

Route::middleware('auth')->controller(SellerController::class)->name('seller.')->prefix('seller')->group(function () {
    Route::get('/register', 'create')->name('register');
    Route::post('/store', 'store')->name('store');

});
Route::middleware(['auth', 'seller'])->controller(SellerController::class)->name('seller.')->prefix('seller')->group(function () {
    Route::get('/outfit/my_outfits', 'my_outfits')->name('outfit.my_outfits');
    Route::get('/create/product', 'createProduct')->name('create.product');
    Route::post('/create/product', 'createProduct')->name('create.product');
    Route::post('/store/values/and/laststep', 'sendToLastStep')->name('send.to.laststep');
    Route::get('/add/item/{outfit}', 'addItem')->name('add.item');
    Route::post('/add/item/{outfit}', 'storeItem')->name('add.item');
    Route::get('/dashboard', 'showDashboard')->name('dashboard');
    Route::post('/accept/order/{order}', 'acceptOrder')->name('accept.order');
});

Route::middleware('auth')->controller(ChatController::class)->group(function () {
    Route::get('/chats', 'index')->name('chats');
    Route::get('/chats/{chat}', 'getConversation')->name('get.conversation');
    Route::get('/chats/connect/{user}', 'connectConversation')->name('connect.conversation');
    Route::post('/chats/{chat}', 'newMessage')->name('new.message');

});