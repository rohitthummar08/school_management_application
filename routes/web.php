<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\AnnouncementDismissalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Auth::routes([
    'register' => false,
]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('teachers', TeacherController::class);
    Route::resource('announcements', AnnouncementController::class)->only(['index', 'create', 'store', 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::resource('students', StudentController::class)->except(['show']);
    Route::resource('parents', ParentController::class)->except(['show']);

    Route::post('/announcements/{announcement}/dismiss', [AnnouncementDismissalController::class, 'dismiss'])
        ->name('announcements.dismiss');
});
