<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $fillable = [
        'title',
        'file_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
