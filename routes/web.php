<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Services\SitemapService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Sitemap
Route::get('/sitemap.xml', function () {
    $sitemapService = new SitemapService();
    return response($sitemapService->generate(), 200)
        ->header('Content-Type', 'application/xml');
});

// Language routes (tr/ and en/)
Route::prefix('{locale}')->where(['locale' => 'tr|en'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{id}/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/portfolio/{id}/{slug}', [PortfolioController::class, 'show'])->name('portfolio.show');
    Route::get('/tools', [ToolsController::class, 'index'])->name('tools.index');
    Route::get('/about', [AboutController::class, 'index'])->name('about.index');
    Route::post('/contact', [ContactController::class, 'store'])->middleware('rate.limit')->name('contact.store');
});

// Default routes (redirect to Turkish)
Route::get('/', function () {
    return redirect('/tr');
});

// Admin Login
Route::get('qTnzV62SjDYBsPaI/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('qTnzV62SjDYBsPaI/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('admin.login.post');
Route::post('qTnzV62SjDYBsPaI/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('admin.logout');

// Admin routes
Route::prefix('qTnzV62SjDYBsPaI')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('blogs', App\Http\Controllers\Admin\BlogController::class);
    Route::resource('portfolios', App\Http\Controllers\Admin\PortfolioController::class);
    Route::resource('slides', App\Http\Controllers\Admin\SlideController::class);
    Route::resource('galleries', App\Http\Controllers\Admin\GalleryController::class);
    Route::get('settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [App\Http\Controllers\Admin\SettingsController::class, 'store'])->name('settings.store');
    Route::get('statistics', [App\Http\Controllers\Admin\StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('messages', [App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{id}', [App\Http\Controllers\Admin\MessageController::class, 'show'])->name('messages.show');
    Route::post('backup/database', [App\Http\Controllers\Admin\BackupController::class, 'database'])->name('backup.database');
    Route::post('backup/assets', [App\Http\Controllers\Admin\BackupController::class, 'assets'])->name('backup.assets');
    Route::get('audit-logs', [App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audit-logs.index');
});
