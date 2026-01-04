<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lyric;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Purchase;
use App\Models\UserAccount;

class DashboardController extends Controller
{
    
    public function index()
    {
        // $user = Auth::user();
        // $lyrics = Lyric::where('user_id', $user->id)->latest()->get();
        // $earnings = Purchase::whereHas('lyric', fn($q)=> $q->where('user_id', $user->id))->sum('amount');
        // $recentOrders = Purchase::whereHas('lyric', fn($q)=> $q->where('user_id', $user->id))->latest()->limit(10)->get();

        // return response()->json([ 'lyrics' => $lyrics, 'earnings' => $earnings, 'recent_orders' => $recentOrders ]);


        return view('dashboard', [
            'user' => auth()->user(),
            'lyrics' => auth()->user()->lyrics()->latest()->get(),
        ]);
    }
    public function payments()
    {
        $user = Auth::user();
        return view('seller/Payments', [
            'user' => auth()->user(),
            'user_account' => UserAccount::where('user_id', $user->id)->first(),
        ]);
    }
    public function sales()
    {
        $user = Auth::user();
        return view('seller/Sales', [
            'user' => auth()->user(),
            'user_account' => UserAccount::where('user_id', $user->id)->first(),
        ]);
    }
    public function sellerFaqs()
    {
        return view('seller/FAQs', [
            'user' => auth()->user(),
        ]);
    }
    public function updatePayPalEmail(Request $request)
    {
        $user = Auth::user();

        // Validate input (recommended)
        $request->validate([
            'paypal_email' => 'required|email'
        ]);

        // Find the latest account or create a new one if missing
        $user_account = UserAccount::firstOrNew(
            ['user_id' => $user->id], // Match condition
        );

        // Update PayPal email
        $user_account->paypal_email = $request->paypal_email;

        // Save the record (creates if new, updates if existing)
        $user_account->save();

        // Optionally return or redirect
        // return back()->with('success', 'PayPal email updated.');
    }
}
