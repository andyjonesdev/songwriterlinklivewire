<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LyricPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'stripe_session_id',
        'user_id',
        'lyric_id',
        'amount',
        'currency',
    ];
}

