<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BriefApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'brief_id',
        'applicant_id',
        'pitch_text',
        'portfolio_item_id',
        'status',
    ];

    public function brief()
    {
        return $this->belongsTo(Brief::class);
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function portfolioItem()
    {
        return $this->belongsTo(PortfolioItem::class);
    }
}
