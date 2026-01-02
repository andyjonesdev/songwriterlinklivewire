<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lyric extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','title','genre','content','price','status','slug', 'mood', 'theme', 'pov', 'language'];
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
}
