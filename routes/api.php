<?php   

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CarouselItemsController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LoginController;
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

//public API's
//usr 11-16

 //   Route::post('/login', [AuthController::class, 'login'])->name('user.login');
 //   Route::post('/user',  'store'               )->name('user.store');



/*protected API's
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::controller(CarouselItemsController::class)->group(function(){
    Route::get('/carousel',             'index');
    Route::get('/carousel/{id}',        'show');
    Route::post('/carousel',            'store');
    Route::put('/carousel/{id}',        'update');
    Route::delete('/carousel/{id}',     'destroy');
});
*/
Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(UserController::class)->group(function(){
    Route::get('/user',                 'index');
    Route::get('/user/{id}',            'show');

    Route::put('/user/{id}',            'update')->name('user.update');
    Route::put('/user/email/{id}',      'email')->name('user.email');
    Route::put('/user/password/{id}',   'password')->name('user.password');
    Route::put('/user/image/{id}',      'image')->name('user.image');
    Route::delete('/user/{id}',         'destroy');
    });

    //user specific APIS
    Route::put('/user/addProduct', [CarsumartController::class, 'addPProduct'])->name('user.addProduct');

    //carsumart
    
    Route::post('/logout', [LoginController::class, 'logout']);
});
//carsumart
Route::middleware(['web', 'auth:sanctum'])->group(function () {
    

});
    Route::post('/register', [LoginController::class, 'register'])->name('user.register');
    Route::post('/login', [LoginController::class, 'login'])->name('user.login');
    





//message activity

Route::controller(MessageController::class)->group(function () {
    Route::delete('/message/{id}', 'destroy');
    Route::get('/message', 'index');
    Route::get('/message/{id}', 'show');
    Route::post('/message', 'create');
    Route::put('/message/{id}', 'update');
    Route::get('/message/{id}', 'search');


});

// Route::delete('/message/{id}', [MessageController::class, 'destroy']);
// Route::get('/message', [MessageController::class, 'index']);
// Route::get('/message/{id}', [MessageController::class, 'show']);
// Route::post('/message', [MessageController::class, 'store']);
// Route::put('/message/{id}', [MessageController::class, 'update']);


// Route::get('/user', [UserController::class, 'index']);
// Route::get('/user/{id}', [UserController::class, 'show']);
// Route::post('/user', [UserController::class, 'store'])->name('user.store');
// Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
// Route::put('/user/email/{id}', [UserController::class, 'email'])->name('user.email');
// Route::put('/user/password/{id}', [UserController::class, 'password'])->name('user.password');
// Route::delete('/user/{id}', [UserController::class, 'destroy']);