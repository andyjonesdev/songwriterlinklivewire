<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

use App\Http\Controllers\API\SellerDashboardController;
use App\Http\Controllers\API\BuyerDashboardController;
use App\Http\Controllers\LyricController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Auth\BuyerRegisterController;
use App\Http\Controllers\StripeWebhookController;

Route::get('/', [LyricController::class, 'welcome'])->name('home');

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});


// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
    
Route::get('/buy-lyrics', [LyricController::class, 'buyLyrics'])->name('buyLyrics');
Route::get('/success', [LyricController::class, 'success'])->name('success');

Route::get('/lyrics/buy/{lyric:slug}', [LyricController::class, 'show'])->name('lyricsShow');

Route::get('/profile/{user}', [UserController::class, 'show'])->name('profile.show');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/blog', [BlogController::class, 'blog'])->name('blog');
Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blogShow');
