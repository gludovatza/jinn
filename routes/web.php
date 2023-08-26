<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Filament admin provider-ben a path-ban állítottam be, hogy az üres path legyen az admin főoldala
// Route::get('/', function () {
//     // return view('welcome');
//     return redirect(route('filament.admin.pages.dashboard'));
// });

// Route::get('download/{document}', [DocumentController::class, 'download']);
