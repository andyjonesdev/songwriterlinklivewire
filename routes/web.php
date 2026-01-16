<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LyricController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Auth\BuyerRegisterController;
use App\Http\Controllers\StripeWebhookController;


use App\Models\Blog;
use App\Livewire\BlogEdit;

Route::get('/', [LyricController::class, 'welcome'])->name('home');

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

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


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/dashboard/buyer', [BuyerDashboardController::class, 'index'])->name('buyerdashboard');
    // Route::get('/dashboard/seller', [SellerDashboardController::class, 'index'])->name('sellerdashboard');


    // Route::get('/lyrics/create', \App\Livewire\CreateLyric::class)
    // ->name('lyrics.create');
    // Route::get('/lyrics/edit', \App\Livewire\EditLyric::class)
    // ->name('lyrics.edit');

    Route::get('/dashboard/payments', function () {
        return view('dashboard.payments', [
            'user_account' => auth()->user()->account,
        ]);
    })->name('dashboard.payments');

    Route::get('/sales', [DashboardController::class, 'sales'])->name('sales');
    // Route::get('/seller/faqs', [SellerDashboardController::class, 'sellerFaqs'])->name('sellerFaqs');

    Route::get('/user/profile/edit', [UserController::class, 'edit'])->name('profile.edit');

    Route::prefix('/lyrics')->group(function () {

        Route::get('/', [LyricController::class, 'index'])->name('lyrics.index');

        Route::get('/create', function () {
            return view('lyrics.create');
        })->name('lyrics.create');

        Route::get('/{lyric}/edit', function (\App\Models\Lyric $lyric) {
            return view('lyrics.edit', compact('lyric'));
        })->name('lyrics.edit');

        // Route::get('/{lyric}/promote', function (\App\Models\Lyric $lyric) {
        //     return view('lyrics.promote', compact('lyric'));
        // })->name('lyrics.promote');

        // Route::get('/{lyric}/promote', \App\Livewire\PromoteLyric::class)->name('lyrics.promote');

        // Route::view("/{lyric}/promote",'lyrics.promote')->name('lyrics.promote');
        Route::get('/{lyric}/promote', [LyricController::class, 'promote'])->name('lyrics.promote');
        
        // Route::post('/', [LyricController::class, 'store'])
        //     ->name('lyricsSave');
        // Route::get('/{lyric:slug}/edit', [LyricController::class, 'edit'])
        //     ->name('lyricsEdit');
        // Route::put('/{lyric:slug}', [LyricController::class, 'update'])
        //     ->name('lyricsUpdate');
        Route::delete('/{lyric:slug}', [LyricController::class, 'destroy'])
            ->name('lyrics.destroy');

    });

    Route::middleware(['auth', 'admin.user'])->get('/admin/blog', function () {
        return view('blog.admin');
    })->name('blog.admin');

    Route::middleware(['auth'])->get('/admin/blog/create', function () {
        return view('blog.create');
    })->name('blog.create');


    Route::middleware(['auth'])->get('/admin/blog/{blog:slug}/edit', BlogEdit::class)
        ->name('blog.edit');

    Route::get('/seller/profile/edit', function () {
        return view('users.edit'); // blade with livewire
    })->name('users.edit');

    Route::get('/seller/sales', function () {
        return view('users.sales'); // blade with livewire
    })->name('users.sales');

    Route::get('/buyer/purchases', function () {
        return view('users.purchases'); // blade with livewire
    })->name('users.purchases');

    Route::get('/buyer/favorites', function () {
        return view('users.favorites'); // blade with livewire
    })->name('users.favorites');

    Route::get('/music/upload', function () {
        return view('music.upload');
    })->name('music.upload');

    Route::post('/lyrics/{lyric:slug}/save', [LyricController::class, 'favorite'])
    ->name('lyrics.save');

    Route::delete('/lyrics/{lyric:slug}/unsave', [LyricController::class, 'destroyFavorite'])
    ->name('lyrics.unsave');

    // Route::middleware(['auth', 'admin.user'])->group(function () {
    //     Route::prefix('blog/admin')->group(function () {
    //         Route::get('/list', [BlogController::class, 'blogAdmin'])
    //             ->name('blog.index');
    //         Route::get('/create', [BlogController::class, 'create'])
    //             ->name('blogCreate');
    //         Route::post('/', [BlogController::class, 'store'])
    //             ->name('blogSave');
    //         Route::get('/{blog:slug}/edit', [BlogController::class, 'edit'])
    //             ->name('blogEdit');
    //         Route::put('/{blog:slug}', [BlogController::class, 'update'])
    //             ->name('blogUpdate');
    //         Route::delete('/{blog:slug}', [BlogController::class, 'destroy'])
    //             ->name('blogDestroy');
    //     });
    // });
});

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
    
Route::get('/buy-lyrics', [LyricController::class, 'buyLyrics'])->name('buyLyrics');
Route::get('/success', [LyricController::class, 'success'])->name('success');

Route::get('/lyrics/buy/{lyric:slug}', [LyricController::class, 'show'])->name('lyrics.show');

Route::get('/lyricist/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
// Route::get('/blog', [BlogController::class, 'blog'])->name('blog');
// Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blogShow');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);