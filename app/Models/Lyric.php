<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lyric extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'genre',
        'content',
        'price',
        'status',
        'slug',
        'mood',
        'theme',
        'pov',
        'language',
        'social_used',
        'ai_flagged',
        'ai_flag_reason',
        'ai_confidence',
        'ai_approved',
    ];
    protected $appends = ['snippet'];

    protected $casts = [
        'ai_flagged'  => 'boolean',
        'ai_approved' => 'boolean',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lyric) {
            // Only generate slug if it doesn't exist
            if (empty($lyric->slug)) {
                $baseSlug = Str::slug($lyric->title);

                // Make slug unique
                $count = static::where('slug', 'LIKE', "{$baseSlug}%")->count();
                $lyric->slug = $count ? "{$baseSlug}-{$count}" : $baseSlug;
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function licenseTemplates()
    {
        return $this->belongsToMany(LicenseTemplate::class, 'license_lyric');
    }
    public function getSnippetAttribute()
    {
        return \Str::limit($this->content, 500);
    }
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeNotAiFlagged($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('ai_flagged')
              ->orWhere('ai_flagged', 0)
              ->orWhere('ai_approved', 1);
        });
    }
    public function writer() // lyric author
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_lyrics')
            ->withTimestamps();
    }
    public function promotions()
    {
        return $this->hasMany(LyricPromote::class);
    }

}
