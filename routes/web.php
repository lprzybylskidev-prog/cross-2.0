<?php

declare(strict_types=1);

use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:home.view|admin',
])->group(function (): void {
    Route::get('/', HomeController::class)->name('home.view');
});
