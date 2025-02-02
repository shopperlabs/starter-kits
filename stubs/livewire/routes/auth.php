<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Pages;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function (): void {
    Volt::route('register', 'pages.auth.register')
        ->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function (): void {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

    Volt::route('/account', 'pages.account.index')->name('account');

    Route::prefix('account')->as('account.')->group(function (): void {
        Volt::route('profile', 'pages.account.profile')->name('profile');
        Route::get('addresses', Pages\Account\Addresses::class)->name('addresses');
        Route::get('orders', Pages\Account\Orders::class)->name('orders');
        Volt::route('orders/{number}', 'pages.account.orders.detail')->name('orders.detail');
    });
});
