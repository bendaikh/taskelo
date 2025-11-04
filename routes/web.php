<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest routes (Authentication)
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Registration disabled
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Clients
    Route::resource('clients', ClientController::class);

    // Projects
    Route::resource('projects', ProjectController::class);

    // Tasks
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Payments
    Route::resource('payments', PaymentController::class);

    // Expenses
    Route::resource('expenses', ExpenseController::class)->only(['index', 'create', 'store', 'destroy']);

    // Expense Categories
    Route::resource('expense-categories', ExpenseCategoryController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('/payments/export/csv', [PaymentController::class, 'exportCsv'])->name('payments.export.csv');
    Route::get('/payments/export/pdf', [PaymentController::class, 'exportPdf'])->name('payments.export.pdf');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::put('/settings/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.preferences');

    // Businesses (My Business)
    Route::resource('businesses', BusinessController::class);
    
    // Business flow builder API endpoints
    Route::post('/businesses/{business}/nodes', [BusinessController::class, 'createNode'])->name('businesses.nodes.create');
    Route::put('/businesses/{business}/nodes/{node}', [BusinessController::class, 'updateNode'])->name('businesses.nodes.update');
    Route::delete('/businesses/{business}/nodes/{node}', [BusinessController::class, 'deleteNode'])->name('businesses.nodes.delete');
    Route::post('/businesses/{business}/edges', [BusinessController::class, 'createEdge'])->name('businesses.edges.create');
    Route::delete('/businesses/{business}/edges/{edge}', [BusinessController::class, 'deleteEdge'])->name('businesses.edges.delete');
});

