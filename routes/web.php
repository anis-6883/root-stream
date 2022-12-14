<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Install\InstallController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HighlightController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LiveMatchController;
use App\Http\Controllers\ManageAppController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PopularSeriesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SportsTypeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['install'])->group(function () {

    Auth::routes(['register' => false]);

    Route::get('/', [HomeController::class, 'index']);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(['auth'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/manage_app/{app_unique_id?}', [ManageAppController::class, 'index'])->name('manage_app');
        Route::post('/store_app_settings/{app_id}/{platform}', [ManageAppController::class, 'store_app_settings'])->name('store_app_settings');
        Route::get('/notifications/deleteall', [NotificationController::class, 'deleteall']);
        Route::post('/notifications/delete/selectedNotifications', [NotificationController::class, 'deleteSelectedNotifications'])->name('delete.selected.notification');
        Route::post('/subscriptions/reorder', [SubscriptionController::class, 'reorder']);
        Route::get('/subscriptions/get_subscriptions/{app_id}', [SubscriptionController::class, 'get_subscriptions']);
        Route::get('/users/app/{app_unique_id}', [UserController::class, 'index']);
        Route::get('/payments/{app_unique_id?}', [PaymentController::class, 'index']);
        Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show');
        //Profile Controller
        Route::get('profile/show', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('password/change', [ProfileController::class, 'password_change'])->name('password.change');
        Route::post('password/update', [ProfileController::class, 'update_password'])->name('password.update');
        //Settings Controller
        Route::any('/general_settings', [SettingController::class, 'general'])->name('general_settings');
        Route::any('/cache_clear', [SettingController::class, 'cache_clear'])->name('cache_clear');
        Route::post('/store_settings', [SettingController::class ,'store_settings'])->name('store_settings');
        Route::any('/database_backup', [BackupController::class, 'index'])->name('database_backup');

        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('admins', AdminController::class);
        Route::resource('apps', AppController::class);
        Route::resource('sports_types', SportsTypeController::class);
        Route::resource('live_matches', LiveMatchController::class);
        Route::resource('popular_series', PopularSeriesController::class);
        Route::resource('highlights', HighlightController::class);
        Route::resource('notifications', NotificationController::class);
        Route::resource('subscriptions', SubscriptionController::class);
        Route::resource('users', UserController::class);

    });

});

Route::get('/installation', [InstallController::class, 'index']);
Route::get('/install/database', [InstallController::class, 'database']);
Route::post('/install/process_install', [InstallController::class, 'process_install']);
Route::get('/install/create_user', [InstallController::class, 'create_user']);
Route::post('/install/store_user', [InstallController::class, 'store_user']);
Route::get('/install/system_settings', [InstallController::class, 'system_settings']);
Route::post('/install/finish', [InstallController::class, 'final_touch']);

Route::get('/server_cache_clear', [WebsiteController::class, 'server_cache_clear']);