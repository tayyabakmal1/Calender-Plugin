<?php

use Illuminate\Support\Facades\Route;
use Platform\Plugins\Calendar\Http\Controllers\TaskController;

Route::group([
    'prefix' => 'admin/calendar',
    'as' => 'admin.calendar.',
    'middleware' => ['web', 'auth'],
], function () {
    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::get('/create', [TaskController::class, 'create'])->name('create');
    Route::post('/store', [TaskController::class, 'store'])->name('store');
    Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
    Route::put('/{task}', [TaskController::class, 'update'])->name('update');
    Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
    Route::get('/calendar-view', [TaskController::class, 'calendar'])->name('calendar');
    Route::get('/calendar-events', [TaskController::class, 'calendarEvents'])->name('calendar.events');
}); 