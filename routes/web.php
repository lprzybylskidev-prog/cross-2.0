<?php

declare(strict_types=1);

use App\Http\Controllers\Debtors\DebtorsIndexController;
use App\Http\Controllers\UserPreferences\UpdateUserPreferencesController;
use Illuminate\Support\Facades\Route;

Route::put('/preferences', UpdateUserPreferencesController::class)
    ->middleware('route_permission')
    ->name('preferences.update');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:debtors.view|admin',
])->group(function (): void {
    Route::redirect('/', '/debtors');
    Route::get('/debtors', DebtorsIndexController::class)->name('debtors.view');
});
