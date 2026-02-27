<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;

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

/*
|--------------------------------------------------------------------------
| Blog Routes
|--------------------------------------------------------------------------
*/

// Blog Category Routes
Route::prefix('blog-categories')->group(function () {
    // Public routes
    Route::get('/', [BlogCategoryController::class, 'index'])->name('blog-categories.index');
    Route::get('/active', [BlogCategoryController::class, 'active'])->name('blog-categories.active');
    Route::get('/{blogCategory}', [BlogCategoryController::class, 'show'])->name('blog-categories.show');
    Route::get('/{category}/blogs', [BlogController::class, 'getBlogsByCategory'])->name('blog-categories.blogs');

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [BlogCategoryController::class, 'store'])->name('blog-categories.store');
        Route::put('/{blogCategory}', [BlogCategoryController::class, 'update'])->name('blog-categories.update');
        Route::delete('/{blogCategory}', [BlogCategoryController::class, 'destroy'])->name('blog-categories.destroy');
        Route::patch('/{blogCategory}/toggle-activation', [BlogCategoryController::class, 'toggleActivation'])->name('blog-categories.toggle-activation');
    });
});

// Blog Routes
Route::prefix('blogs')->group(function () {
    // Public routes
    Route::get('/', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/published', [BlogController::class, 'published'])->name('blogs.published');
    Route::get('/{blog}', [BlogController::class, 'show'])->name('blogs.show');

    // Protected routes
});

