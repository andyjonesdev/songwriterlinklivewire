<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotedProfile extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'starts_at',
        'ends_at',
        'stripe_payment_intent_id',
        'active',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'starts_at'  => 'datetime',
            'ends_at'    => 'datetime',
            'active'     => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
