<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\OutfitController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\LocationController;
use App\Http\Controllers\admin\AgeController;
use App\Http\Controllers\admin\SellerController;
use App\Http\Controllers\admin\TagController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\VisitorController;
use App\Http\Controllers\admin\OptionValueController;
use App\Http\Controllers\admin\ValueController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\OptionController;



//seller or admin
Route::controller(OutfitController::class)->middleware('auth')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/outfit/{outfit_id}/{seller_id}/edit', 'edit')->name('outfit.edit');
        Route::put('/outfit/{id}/update', 'update')->name('outfit.update');
        Route::delete('/outfit/{id}/{seller_id}/delete', 'delete')->name('outfit.delete');
});

Route::controller(OutfitController::class)->middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/outfits/index', 'admin_index')->name('outfits.index');
        Route::get('/outfit/create', 'create')->name('outfit.create');
        Route::post('/outfit/store', 'store')->name('outfit.store');
        Route::get('/outfit/{seller_id}/{outfit_id}/show', 'show')->name('outfit.show');

        // Route::get('/outfit/{outfit_id}/{seller_id}/edit', 'edit')->name('outfit.edit');
        // Route::put('/outfit/{id}/update', 'update')->name('outfit.update');
        // Route::delete('/outfit/{id}/{seller_id}/delete', 'delete')->name('outfit.delete');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/index', [DashboardController::class, 'index'])->name('dashboard');
        Route::resources([
            'locations' => LocationController::class,
            'ages' => AgeController::class,
            'sellers' => SellerController::class,
            'tags' => TagController::class,
            'users' => UserController::class,
            'visitors' => VisitorController::class,
            'options_values' => OptionValueController::class,
            'options' => OptionController::class,
            'values' => ValueController::class,
            'orders' => ValueController::class,
        ]);
});

