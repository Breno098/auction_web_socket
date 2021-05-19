<?php

use App\Events\ItemOpen;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ItemController;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::get('/item-open', function () {
    broadcast(new ItemOpen());
});


Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/bid/{item}', [GeneralController::class, 'bid'])->name('bid.item');

    Route::resource('category', CategoryController::class);
    Route::resource('item', ItemController::class);

    Route::post('/item/updateWithImage/{item}', [ItemController::class, 'updateWithImage'])->name('item.update-with-image');
});


