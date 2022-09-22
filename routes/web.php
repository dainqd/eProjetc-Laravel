<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExtraClassController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->withoutMiddleware('auth')->name('home');

Route::get('/portal', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/contact-us', [DashboardController::class, 'contact'])->name('contact');

Route::prefix('/users')->name('users.')->controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::post('create', 'store')->name('store');
    Route::get('edit/{user}', 'edit')->name('edit');
    Route::post('edit/{user}', 'update')->name('update');
    Route::get('delete/{user}', 'destroy')->name('destroy');
});
Route::prefix('/feedbacks')->name('feedbacks.')->controller(FeedbackController::class)->group(function () {
    Route::post('/create', 'store')->name('store');
    Route::get('/create', 'create')->name('create');
});

Route::name('students.')->controller(StudentController::class)->group(function () {
    Route::get('join-class', 'joinClass')->name('join-class');
    Route::post('join-class', 'handleJoinClass')->name('handle-join-class');
    Route::get('settings', 'settings')->name('settings');
    Route::post('settings', 'handleSettings')->name('handle-settings');
    Route::get('parents', 'parents')->name('parents');
    Route::post('parents', 'addParent')->name('parents.add');
    Route::get('parents/remove', 'removeParent')->name('parents.remove');
    Route::get('parents/{code}/confirm', 'confirm')->name('parents.confirm');
});

Route::prefix('/classes/{group}')->group(function () {
    Route::prefix('/extra-classes')->name('extra-classes.')->controller(ExtraClassController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store')->name('store');
        Route::get('edit/{extraClass}', 'edit')->name('edit');
        Route::post('edit/{extraClass}', 'update')->name('update');
        Route::get('delete/{extraClass}', 'destroy')->name('destroy');
    });

    Route::prefix('/resources')->name('resources.')->controller(ResourceController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store')->name('store');
        Route::get('edit/{resource}', 'edit')->name('edit');
        Route::post('edit/{resource}', 'update')->name('update');
        Route::get('delete/{resource}', 'destroy')->name('destroy');
    });

    Route::prefix('/tests')->name('tests.')->controller(TestController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/send-to-parent', 'index')->name('send-to-parent');
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store')->name('store');
        Route::get('update/{test}', 'edit')->name('edit');
        Route::post('update/{test}', 'update')->name('update');
        Route::get('delete/{test}', 'destroy')->name('destroy');
        Route::get('marks/{test}', 'mark')->name('mark');
        Route::post('marks/{test}', 'processGiveMark')->name('give-mark');
        Route::post('marks/{test}/edit', 'processEditMark')->name('edit-mark');
    });

    Route::prefix('/scores')->name('scores.')->controller(ScoreController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{user}', 'listByStudent')->name('list-by-student');
        Route::get('/{user}/send-to-parent', 'getReportScore')->name('send-to-parent');
    });
});

Route::prefix('/classes')->name('classes.')->controller(GroupController::class)->group(function () {
    Route::get('/', 'index')->name('ongoing');// ongoing
    Route::get('/archived', 'archived')->name('archived'); // archived
    Route::get('/create', 'create')->name('create');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{group}', 'edit')->name('edit');
    Route::post('/edit/{group}', 'update')->name('update');
    Route::get('/{group}/archived/on', 'onArchived')->name('archived.on');
    Route::get('/{group}/archived/off', 'offArchived')->name('archived.off');
    Route::get('/{group}/remove/{user}', 'remove')->name('remove');
    Route::get('/{group}', 'show')->name('show');
});

Route::prefix('/feedbacks')->name('feedbacks.')->controller(FeedbackController::class)->group(function () {
    Route::post('create', 'store')->name('store');
    Route::get('create', 'create')->name('create');
    Route::get('/', 'index')->name('index');
    Route::get('show/{feedback}', 'show')->name('show');
    Route::get('delete/{feedback}', 'destroy')->name('destroy');
});

Route::name('auth.')->withoutMiddleware('auth')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'handleRegister'])->name('handle-register');
});
