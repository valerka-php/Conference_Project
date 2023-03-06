<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConferenceCategoryController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\Export\CommentExportController;
use App\Http\Controllers\Export\ConferenceExportController;
use App\Http\Controllers\Export\ListenerExportController;
use App\Http\Controllers\Export\ReportExportController;
use App\Http\Controllers\FavoriteReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportCategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserFavoriteReportController;
use App\Http\Controllers\ZoomMeetingController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Laravel\Cashier\Subscription;

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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/meetings', [ZoomMeetingController::class, 'index'])->name('meetings.all');
Route::get('/dashboard', function () {
    return inertia('Dashboard', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/conferences/create', [ConferenceController::class, 'create'])->name('conferences.create');
    Route::post('/conferences', [ConferenceController::class, 'store'])->name('conferences.store');
    Route::get('/conferences/{conference}', [ConferenceController::class, 'show'])->name('conferences.show');
    Route::get('/conferences/{conference}/edit', [ConferenceController::class, 'edit'])->name('conferences.edit');
    Route::put('/conferences/{conference}', [ConferenceController::class, 'update'])->name('conferences.update');
    Route::delete('/conferences/{conference}', [ConferenceController::class, 'delete'])->name('conferences.delete');
    Route::put('/conferences/{conference}/join', [ConferenceController::class, 'join'])->name('conferences.join');
    Route::put('/conferences/{conference}/leave', [ConferenceController::class, 'leave'])->name('conferences.leave');

    Route::get('/reports/{conference}/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports/{conference}', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{conference}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('/report/{report}', [ReportController::class, 'index'])->name('report.home');
    Route::delete('/reports/{report}', [ReportController::class, 'delete'])->name('reports.delete');
    Route::put('/reports/{report}/leave', [ReportController::class, 'leave'])->name('reports.leave');
    Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])->name('reports.edit');
    Route::post('/reports/{report}/update/{conference}', [ReportController::class, 'update'])->name('reports.update');

    Route::get('/comments/{report}/create', [CommentController::class, 'create'])->name('comments.create');
    Route::get('/comments/{report}', [CommentController::class, 'index'])->name('comments.get');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit/{report}', [CommentController::class, 'edit'])->name('comments.edit');
    Route::post('/comments/{comment}/update', [CommentController::class, 'update'])->name('comments.update');

    Route::get('/download/{presentation}', function ($presentation) {
        return Storage::disk('public')->download("presentations/$presentation");
    })->name('downloads.presentation');

    Route::get('/downloads/{file}', function ($file) {
        return Storage::disk('public')->download("$file");
    })->name('downloads.file');

    Route::post('/favorite/{report}/', [UserFavoriteReportController::class, 'store'])->name('favorites.store');
    Route::delete('/favorite/{report}', [UserFavoriteReportController::class, 'delete'])->name('favorites.delete');
    Route::get('/favorites/{user}', [FavoriteReportController::class, 'index'])->name('favorites.index');

    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories', [CategoryController::class, 'show'])->name('categories.show');
    Route::delete('/categories/{category}', [CategoryController::class, 'delete'])->name('categories.delete');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');

    Route::get('/conferences/category/{category}', [ConferenceCategoryController::class, 'index'])->name('conferences-category.index');
    Route::get('/reports/category/{category}', [ReportCategoryController::class, 'index'])->name('report-category.index');

    Route::get('/search', [SearchController::class, 'index'])->name('search.index');

    Route::get('/plans', [StripeController::class, 'index'])->name("plans.show");
    Route::get('/subscriptions/{plan}', [StripeController::class, 'subscription'])->name("subscription.create");
    Route::get('/cancel/{plan}', [StripeController::class, 'cancel'])->name("subscription.cancel");
});

require __DIR__ . '/auth.php';

