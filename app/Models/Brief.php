<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brief extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'genres',
        'compensation_type',
        'compensation_detail',
        'deadline',
        'status',
        'expires_at',
        'stripe_payment_intent_id',
    ];

    protected function casts(): array
    {
        return [
            'genres'     => 'array',
            'deadline'   => 'date',
            'expires_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(BriefApplication::class);
    }
}
