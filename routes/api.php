<?php

use App\Http\Controllers\Api\AlbumController as ApiAlbumsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/albums', [ApiAlbumsController::class, 'index'])->name('api.albums.index');
//qui si può usare sia lo ($slug che il $album) perché si è usato nel model Album il getRouteKeyName()
Route::get('/albums/{album}', [ApiAlbumsController::class, 'show'])->name('api.albums.show');
