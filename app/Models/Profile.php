<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'display_name',
        'slug',
        'bio',
        'location',
        'country',
        'profile_photo_path',
        'profile_photo_flagged',
        'genres',
        'social_links',
        'is_searchable',
        'search_boost_weight',
        'views_count',
        'connections_count',
        'ai_bio_flagged',
        'ai_bio_confidence',
        'ai_bio_reason',
    ];

    protected function casts(): array
    {
        return [
            'genres'               => 'array',
            'social_links'         => 'array',
            'profile_photo_flagged' => 'boolean',
            'is_searchable'        => 'boolean',
            'ai_bio_flagged'       => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
