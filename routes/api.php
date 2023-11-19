<?php   

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CarouselItemsController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\UserController;
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

Route::get('/carousel', [CarouselItemsController::class, 'index']);
Route::get('/carousel/{id}', [CarouselItemsController::class, 'show']);
Route::post('/carousel', [CarouselItemsController::class, 'store']);
Route::put('/carousel/{id}', [CarouselItemsController::class, 'update']);
Route::delete('/carousel/{id}', [CarouselItemsController::class, 'destroy']);


//message activity
Route::delete('/message/{id}', [MessageController::class, 'destroy']);
Route::get('/message', [MessageController::class, 'index']);
Route::get('/message/{id}', [MessageController::class, 'show']);
Route::post('/message', [MessageController::class, 'store']);
Route::put('/message/{id}', [MessageController::class, 'update']);

Route::get('/user', [UserController::class, 'index']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);

