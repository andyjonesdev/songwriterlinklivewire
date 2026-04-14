<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'file_path',
        'file_size',
        'duration_seconds',
        'is_public',
        'ai_flagged',
    ];

    protected function casts(): array
    {
        return [
            'is_public'  => 'boolean',
            'ai_flagged' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
