<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'event', 'detail', 'created_at'];

    protected function casts(): array
    {
        return [
            'detail'     => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
