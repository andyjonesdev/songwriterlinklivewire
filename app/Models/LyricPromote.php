<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LyricPromote extends Model
{
    use HasFactory;
    protected $fillable = [
        'stripe_session_id',
        'user_id',
        'lyric_id',
        'placement',
        'duration',
        'bid',
        'amount',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];

    public function lyric()
    {
        return $this->belongsTo(Lyric::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
