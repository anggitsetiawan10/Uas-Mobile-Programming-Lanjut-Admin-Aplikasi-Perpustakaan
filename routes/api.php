<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\UserProfileController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Route::get('/books/latest', [BookApiController::class, 'latest']);
Route::middleware('auth:sanctum')->get('/books/latest', [BookApiController::class, 'latest']);
Route::get('/books/most-borrowed', [BookApiController::class, 'mostBorrowed']);
Route::get('/books/top-rated', [BookApiController::class, 'topRated']);

// routes/api.php
Route::get('/books/years', [BookApiController::class, 'getAvailableYears']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/books/search', [BookApiController::class, 'search']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reviews/user', [ReviewApiController::class, 'userReviews']);
    Route::post('/reviews', [ReviewApiController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewApiController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewApiController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/loans', [LoanController::class, 'store']);
    Route::get('/loans', [LoanController::class, 'index']);
    Route::delete('/loans/{id}', [LoanController::class, 'destroy']); // ✅ Tambahkan ini
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show']);
    Route::post('/profile', [UserProfileController::class, 'store']); // <- dari PUT ke POST
});

