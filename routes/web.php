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
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\RevenueCategoryController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ProjectSectionController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\DailyTasksController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\ClientPortalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Client Portal Routes
Route::prefix('client')->name('client.')->group(function () {
    // Client guest routes (not authenticated)
    Route::middleware('guest:client')->group(function () {
        Route::get('/login', [ClientAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [ClientAuthController::class, 'login']);
    });

    // Client authenticated routes
    Route::middleware('auth:client')->group(function () {
        Route::post('/logout', [ClientAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [ClientPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/projects', [ClientPortalController::class, 'projects'])->name('projects');
        Route::get('/projects/{id}', [ClientPortalController::class, 'project'])->name('project');
        Route::get('/payments', [ClientPortalController::class, 'payments'])->name('payments');
        Route::get('/tasks', [ClientPortalController::class, 'tasks'])->name('tasks');
    });
});

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
    Route::get('/dashboard/expenses-by-category-data', [DashboardController::class, 'expensesByCategoryData'])
        ->name('dashboard.expenses-by-category-data');

    // Workspaces
    Route::resource('workspaces', WorkspaceController::class);
    Route::post('/workspaces/{workspace}/switch', [WorkspaceController::class, 'switch'])->name('workspaces.switch');

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
    Route::get('/payments/export/csv', [PaymentController::class, 'exportCsv'])->name('payments.export.csv');
    Route::get('/payments/export/pdf', [PaymentController::class, 'exportPdf'])->name('payments.export.pdf');

    // Proposals
    Route::resource('proposals', ProposalController::class);
    Route::get('/proposals/{proposal}/pdf', [ProposalController::class, 'pdf'])->name('proposals.pdf');
    Route::get('/proposals/{proposal}/view-pdf', [ProposalController::class, 'viewPdf'])->name('proposals.view-pdf');

    // Project Sections (Conceptions)
    Route::resource('conceptions', ProjectSectionController::class);
    Route::get('/conceptions/{conception}/pdf/{lang?}', [ProjectSectionController::class, 'generatePdf'])->name('conceptions.pdf');
    Route::get('/conceptions-import', [ProjectSectionController::class, 'showImportForm'])->name('conceptions.import.form');
    Route::post('/conceptions-import', [ProjectSectionController::class, 'import'])->name('conceptions.import');
    Route::get('/conceptions-template', [ProjectSectionController::class, 'downloadTemplate'])->name('conceptions.template');

    // Expenses
    Route::resource('expenses', ExpenseController::class)->only(['index', 'create', 'store', 'destroy']);

    // Expense Categories
    Route::resource('expense-categories', ExpenseCategoryController::class)->only(['index', 'create', 'store', 'destroy']);

    // Revenues
    Route::resource('revenues', RevenueController::class)->only(['index', 'create', 'store', 'destroy']);

    // Revenue Categories
    Route::resource('revenue-categories', RevenueCategoryController::class)->only(['index', 'create', 'store', 'destroy']);

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::put('/settings/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.preferences');
    Route::post('/settings/language', [SettingsController::class, 'updateLanguage'])->name('settings.language');

    // Businesses (My Business)
    Route::resource('businesses', BusinessController::class);
    
    // Business flow builder API endpoints
    Route::post('/businesses/{business}/nodes', [BusinessController::class, 'createNode'])->name('businesses.nodes.create');
    Route::put('/businesses/{business}/nodes/{node}', [BusinessController::class, 'updateNode'])->name('businesses.nodes.update');
    Route::delete('/businesses/{business}/nodes/{node}', [BusinessController::class, 'deleteNode'])->name('businesses.nodes.delete');
    Route::post('/businesses/{business}/edges', [BusinessController::class, 'createEdge'])->name('businesses.edges.create');
    Route::delete('/businesses/{business}/edges/{edge}', [BusinessController::class, 'deleteEdge'])->name('businesses.edges.delete');

    // User Management
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserManagementController::class);

    // Daily Tasks (only for business workspace)
    Route::get('/daily-tasks', [DailyTasksController::class, 'index'])->name('daily-tasks.index');
    Route::post('/daily-tasks', [DailyTasksController::class, 'store'])->name('daily-tasks.store');
    Route::put('/daily-tasks/{task}', [DailyTasksController::class, 'update'])->name('daily-tasks.update');
    Route::patch('/daily-tasks/{task}/status', [DailyTasksController::class, 'updateStatus'])->name('daily-tasks.update-status');
    Route::delete('/daily-tasks/{task}', [DailyTasksController::class, 'destroy'])->name('daily-tasks.destroy');
});

