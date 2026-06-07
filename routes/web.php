<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityUpdateController;
use App\Http\Controllers\HandoverController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard - Daily Activity View
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Activity Status Updates
    Route::post('/activity-logs/{dailyActivityLog}/update', [ActivityUpdateController::class, 'store'])->name('activity-updates.store');
    
    // Handover - Assign to next person
    Route::post('/activity-logs/{dailyActivityLog}/assign', [HandoverController::class, 'assign'])->name('handover.assign');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    
    // Admin-only routes
    Route::middleware('admin')->group(function () {
        // Activity Management
        Route::resource('activities', ActivityController::class);
        
        // User Management
        Route::resource('users', UserController::class);
    });
});
