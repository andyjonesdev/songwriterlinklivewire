<?php

use App\Livewire\OnboardingWizard;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

// ─── Public routes ───────────────────────────────────────────────────────────

Route::get('/', fn () => view('welcome'))->name('home');
Route::get('/members', fn () => view('members.index'))->name('members.index');
Route::get('/members/{profile:slug}', fn ($profile) => view('members.show', compact('profile')))->name('profile.show');
Route::get('/privacy', fn () => view('pages.privacy'))->name('privacy');
Route::get('/terms', fn () => view('pages.terms'))->name('terms');

// ─── Onboarding ──────────────────────────────────────────────────────────────

Route::get('/join', OnboardingWizard::class)->name('onboarding.start');
Route::get('/onboarding/{step}', OnboardingWizard::class)->name('onboarding.step');

// Smart redirect after login / email verification (Fortify home)
Route::middleware('auth')->get('/onboarding/redirect', function () {
    $user = auth()->user();
    if ($user->status === 'active') {
        return redirect()->route('dashboard');
    }
    return redirect()->route('onboarding.step', $user->onboarding_step ?? 1);
})->name('onboarding.redirect');

// ─── Authenticated routes ─────────────────────────────────────────────────────

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    // Members
    Route::get('/members/{profile:slug}/connect', fn () => abort(404))->name('members.connect');

    // Messages
    Route::get('/messages', fn () => view('messages.index'))->name('messages.index');
    Route::get('/messages/{conversation}', fn ($conversation) => view('messages.show', compact('conversation')))->name('messages.show');

    // Briefs
    Route::get('/briefs', fn () => view('briefs.index'))->name('briefs.index');
    Route::get('/briefs/create', fn () => view('briefs.create'))->name('briefs.create');
    Route::get('/briefs/{brief}', fn ($brief) => view('briefs.show', compact('brief')))->name('briefs.show');
    Route::post('/briefs/{brief}/apply', fn () => abort(404))->name('briefs.apply');

    // Profile management
    Route::get('/profile/edit', fn () => view('profile.edit'))->name('profile.edit');

    // Settings
    Route::redirect('/settings', '/settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
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

    // Data export (GDPR)
    Route::get('/settings/export-data', fn () => abort(501))->name('settings.export-data');

});

// ─── Admin routes ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'verified', 'can:access-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => view('admin.index'))->name('index');
    Route::get('/verification-queue', fn () => view('admin.verification-queue'))->name('verification-queue');
    Route::get('/reports', fn () => view('admin.reports'))->name('reports');
    Route::get('/producer-badges', fn () => view('admin.producer-badges'))->name('producer-badges');
    Route::get('/suspended', fn () => view('admin.suspended'))->name('suspended');
    Route::get('/promotions', fn () => view('admin.promotions'))->name('promotions');
    Route::get('/members', fn () => view('admin.members'))->name('members');
    Route::get('/stats', fn () => view('admin.stats'))->name('stats');
});
