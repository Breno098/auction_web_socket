<?php

use App\Http\Controllers\Adm\TeamController;
use App\Http\Controllers\Adm\CountryController;
use App\Http\Controllers\Adm\GameController;
use App\Http\Controllers\Adm\OfficialController;
use App\Http\Controllers\Adm\CompetitionController;
use App\Http\Controllers\Adm\PlayerController;
use App\Http\Controllers\Adm\StadiumController;

use App\Http\Controllers\Gambler\CompetitionController as GamblerCompetitionController;
use App\Http\Controllers\Gambler\Dashboard as GamblerDashboard;
use App\Http\Controllers\Gambler\GeneralController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});


Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard', function(){
        return Inertia::render('Adm/Dashboard');
    })->name('dashboard');
});


