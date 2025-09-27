<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('login', fn () => redirect('/admin/login'));
    Route::get('register', fn () => redirect('/admin/login'));
});

// Home routes
Route::middleware(['cache.control', 'optimize.response'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
});

// Portfolio routes
Route::prefix('portfolio')->name('portfolio.')->middleware(['cache.control', 'optimize.response'])->group(function () {
    Route::get('/', [PortfolioController::class, 'index'])->name('index');
    Route::get('/{portfolio:slug}', [PortfolioController::class, 'show'])->name('show');
});

// Blog routes
Route::prefix('blog')->name('blog.')->middleware(['cache.control', 'optimize.response'])->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('category');
    Route::get('/{post:slug}', [BlogController::class, 'show'])->name('show');
});

// Comment routes
Route::post('/blog/{post:slug}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Contact routes
Route::post('/contact', [\App\Http\Controllers\ContactMessageController::class, 'store'])
    ->middleware(['throttle:contact'])
    ->name('contact.store');
