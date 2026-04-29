<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'role',
        'artist',
        'year',
        'label',
        'isrc',
        'description',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
