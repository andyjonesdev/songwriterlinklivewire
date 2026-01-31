<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Blog extends Model
{   
    protected $fillable = ['user_id','title','description','category','content','seo_genre','status','slug'];
    protected $appends = ['snippet'];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            // Only generate slug if it doesn't exist
            if (empty($blog->slug)) {
                $baseSlug = Str::slug($blog->title);

                // Make slug unique
                $count = static::where('slug', 'LIKE', "{$baseSlug}%")->count();
                $blog->slug = $count ? "{$baseSlug}-{$count}" : $baseSlug;
            }
        });
    }
    public function getSnippetAttribute()
    {
        return \Str::limit($this->content, 150);
    }
}
