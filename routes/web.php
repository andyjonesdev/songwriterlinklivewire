<?php

use App\Http\Controllers\StripeCheckoutController;
use App\Http\Controllers\StripeIdentityController;
use App\Http\Controllers\StripeWebhookController;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Members as AdminMembers;
use App\Livewire\Admin\ProducerBadges as AdminProducerBadges;
use App\Livewire\Admin\Promotions as AdminPromotions;
use App\Livewire\Admin\ReportQueue as AdminReportQueue;
use App\Livewire\Admin\SuspendedUsers as AdminSuspendedUsers;
use App\Livewire\Admin\VerificationQueue as AdminVerificationQueue;
use App\Livewire\Briefs\BriefCreate;
use App\Livewire\Briefs\BriefIndex;
use App\Livewire\Briefs\BriefManage;
use App\Livewire\Briefs\BriefShow;
use App\Livewire\MemberProfile;
use App\Livewire\MemberSearch;
use App\Livewire\Messages\Inbox as MessagesInbox;
use App\Livewire\Messages\Thread as MessagesThread;
use App\Livewire\NotificationsPage;
use App\Livewire\OnboardingWizard;
use App\Livewire\Portfolio;
use App\Livewire\Analytics;
use App\Livewire\CreditsPage;
use App\Livewire\Settings\Subscription;
use App\Livewire\SplitSheet;
use App\Http\Controllers\CvExportController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SplitSheetController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

// ─── Public routes ───────────────────────────────────────────────────────────

Route::get('/', fn () => view('welcome'))->name('home');
Route::get('/members', MemberSearch::class)->name('members.index');
Route::get('/members/{profile:slug}', MemberProfile::class)->name('profile.show');
Route::get('/privacy', fn () => view('pages.privacy'))->name('privacy');
Route::get('/terms', fn () => view('pages.terms'))->name('terms');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// ─── Stripe webhooks (CSRF exempt — handled in bootstrap/app.php) ────────────

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');

// ─── Onboarding ──────────────────────────────────────────────────────────────

Route::get('/join', OnboardingWizard::class)->name('onboarding.start');

// Smart redirect after login / email verification (Fortify home)
// Must be defined BEFORE the {step} wildcard or it will be swallowed by it
Route::middleware('auth')->get('/onboarding/redirect', function () {
    $user = auth()->user();
    if ($user->status === 'active') {
        return redirect()->route('dashboard');
    }
    // Hold on the email verification notice until they click the link
    if (! $user->hasVerifiedEmail()) {
        return redirect()->route('verification.notice');
    }
    return redirect()->route('onboarding.step', $user->onboarding_step ?? 1);
})->name('onboarding.redirect');

// Stripe routes — must be above {step} wildcard to avoid being swallowed
Route::middleware('auth')->group(function () {
    Route::get('/onboarding/identity/start',      [StripeIdentityController::class, 'start'])->name('identity.start');
    Route::get('/onboarding/identity/return',     [StripeIdentityController::class, 'return'])->name('identity.return');
    Route::get('/onboarding/joining-fee/start',    [StripeCheckoutController::class, 'startJoiningFee'])->name('checkout.joining-fee.start');
    Route::get('/onboarding/joining-fee/return',   [StripeCheckoutController::class, 'joiningFeeReturn'])->name('checkout.joining-fee.return');
    Route::get('/onboarding/subscription/start',   [StripeCheckoutController::class, 'startSubscription'])->name('checkout.subscription.start');
    Route::get('/onboarding/subscription/return',  [StripeCheckoutController::class, 'subscriptionReturn'])->name('checkout.subscription.return');
});

Route::get('/onboarding/{step}', OnboardingWizard::class)->name('onboarding.step');

// ─── Authenticated routes ─────────────────────────────────────────────────────

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    // Messages
    Route::get('/messages', MessagesInbox::class)->name('messages.index');
    Route::get('/messages/{conversation}', MessagesThread::class)->name('messages.show');

    // Portfolio
    Route::get('/portfolio', Portfolio::class)->name('portfolio.index');

    // Briefs
    Route::get('/briefs', BriefIndex::class)->name('briefs.index');
    Route::get('/briefs/create', BriefCreate::class)->name('briefs.create');
    Route::get('/briefs/mine', BriefManage::class)->name('briefs.mine');
    Route::get('/briefs/{brief}', BriefShow::class)->name('briefs.show');

    // Profile management — redirect to the onboarding profile step (step 5 is the profile form)
    Route::get('/profile/edit', fn () => redirect()->route('onboarding.step', 5))->name('profile.edit');

    // Notifications
    Route::get('/notifications', NotificationsPage::class)->name('notifications');

    // Analytics (Pro+)
    Route::get('/analytics', Analytics::class)->name('analytics');

    // Credits / CV (Pro+)
    Route::get('/credits', CreditsPage::class)->name('credits.index');
    Route::get('/credits/export', [CvExportController::class, 'export'])->name('credits.export');

    // Split Sheet (Pro+)
    Route::get('/split-sheet', SplitSheet::class)->name('split-sheet.index');
    Route::get('/split-sheet/export', [SplitSheetController::class, 'export'])->name('split-sheet.export');

    // Settings
    Route::redirect('/settings', '/settings/profile');
    Route::get('/settings/subscription', Subscription::class)->name('settings.subscription');
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
    Route::get('/', AdminDashboard::class)->name('index');
    Route::get('/verification-queue', AdminVerificationQueue::class)->name('verification-queue');
    Route::get('/reports', AdminReportQueue::class)->name('reports');
    Route::get('/producer-badges', AdminProducerBadges::class)->name('producer-badges');
    Route::get('/suspended', AdminSuspendedUsers::class)->name('suspended');
    Route::get('/promotions', AdminPromotions::class)->name('promotions');
    Route::get('/members', AdminMembers::class)->name('members');
});
