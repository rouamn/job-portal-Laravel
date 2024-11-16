<?php

use Illuminate\Support\Facades\Route;




use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobListingController;

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// Job Listings Routes
Route::middleware('auth')->group(function () {

    Route::get('job-listings/create', [JobListingController::class, 'create'])->name('job-listings.create');
    Route::post('job-listings', [JobListingController::class, 'store'])->name('job-listings.store');
    Route::get('job-listings/{id}/edit', [JobListingController::class, 'edit'])->name('job-listings.edit');
    Route::put('job-listings/{id}', [JobListingController::class, 'update'])->name('job-listings.update');
    Route::delete('job-listings/{id}', [JobListingController::class, 'destroy'])->name('job-listings.destroy');
});

Route::get('/', [JobListingController::class, 'index'])->name('job-listings.index');
Route::get('job-listings/{id}', [JobListingController::class, 'show'])->name('job-listings.show');
