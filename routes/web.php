<?php

use App\Events\BidsToUser;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BidController;

Route::get('/user/brod', function () {
    broadcast(new BidsToUser);
});

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');

    Route::get('informations/item/{item}', [InformationController::class, 'item'])->name('informations.item');
    Route::get('informations/bids-to-user', [InformationController::class, 'bidsToUser'])->name('informations.bids-to-user');

    Route::get('/informations/items', [InformationController::class, 'items'])->name('informations.items');
    // Route::get('informations/items-category/{category}', [InformationController::class, 'items'])->name('informations.items-category');

    Route::post('bid/set-to-user/{item}', [BidController::class, 'setToUser'])->name('bid.set-to-user');

    /** CRUD's */
    Route::get('category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('category', [CategoryController::class, 'store'])->name('category.store');
    Route::put('category/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('item', [ItemController::class, 'index'])->name('item.index');
    Route::get('item/{item}/edit', [ItemController::class, 'edit'])->name('item.edit');
    Route::get('item/create', [ItemController::class, 'create'])->name('item.create');
    Route::post('item', [ItemController::class, 'store'])->name('item.store');
    Route::put('item/{item}', [ItemController::class, 'update'])->name('item.update');
    Route::delete('item/{item}', [ItemController::class, 'destroy'])->name('item.destroy');
    Route::post('/item/updateWithImage/{item}', [ItemController::class, 'updateWithImage'])->name('item.update-with-image');
});


