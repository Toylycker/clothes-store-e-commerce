<?php

use App\Http\Controllers\admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\admin\Auth\RegisteredUserController;
use App\Http\Controllers\front\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\OutfitController;
use App\Http\Controllers\front\CommentController;
use App\Http\Controllers\front\SellerController;
use App\Http\Controllers\front\OrderController;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::get('/some', [OrderController::class, 'fetch']);

Route::middleware('auth')->controller(OrderController::class)->group(function(){
    Route::get('/basket', 'basket_')->name('basket');
    Route::get('/add_to_basket/{id}', 'add_to_basket')->name('add_to_basket');
    Route::post('/set_order', 'set_order')->name('set_order');
    Route::get('/my_orders', 'show_orders')->name('my_orders');
    Route::get('/my_sales', 'show_sales')->name('my_sales');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/check', [OutfitController::class, 'check'])->name('check');

Route::get('/results', [HomeController::class, 'results'])->name('results');
Route::get('/language/{key}', [HomeController::class, 'language'])->name('language')->where('key', '[a-z]+');

Route::middleware('auth')->controller(SellerController::class)->name('seller.')->prefix('seller')->group(function () {
    Route::get('/register', 'create')->name('register');
    Route::post('/store', 'store')->name('store');

});

Route::middleware(['auth', 'seller'])->controller(SellerController::class)->name('seller.')->prefix('seller')->group(function () {
    Route::get('/outfit/my_outfits', 'my_outfits')->name('outfit.my_outfits');

});


Route::controller(OutfitController::class)->group(function () {
    Route::get('/outfits/home', 'index')->name('outfits.home');
    Route::get('/outfit/{seller_id}/{outfit_id}/show', 'show')->name('outfit.show');
    Route::get('/outfit/{slug}/favorite', 'favorite')->name('computer.favorite')->where('slug', '[0-9A-Za-z-]+');
    Route::get('/outfit/{slug}/busket', 'busket')->name('computer.busket')->where('slug', '[0-9A-Za-z-]+');
});
Route::middleware(['auth', 'seller'])->controller(OutfitController::class)->group(function () {
    Route::get('/outfit/create', 'create')->name('outfit.create');
});
Route::controller(OutfitController::class)->middleware('auth')->group(function () {
    Route::get('/outfit/{outfit_id}/{seller_id}/edit', 'edit')->name('outfit.edit');
    Route::put('/outfit/{id}/update', 'update')->name('outfit.update');
    Route::delete('/outfit/{id}/{seller_id}/delete', 'delete')->name('outfit.delete');
    Route::post('/outfit/store', 'store')->name('outfit.store');
});

Route::controller(CommentController::class)->middleware('auth')->group(function () {
    Route::post('/comments/{outfitseller_id}/store', 'store')->name('comments.store');
    Route::resource('comments', CommentController::class)->except(['store']);

});

Route::get('/mail', function (){
    Mail::to("hello@gmail.com")->send(new WelcomeMail);
    return redirect()->route('home');
});
// Route::resource('photos', PhotoController::class)->except([
//     'create', 'store', 'update', 'destroy'
// ]);