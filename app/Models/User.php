<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'stripe_customer_id',
        'subscription_tier',
        'subscription_expires_at',
        'subscription_term',
        'id_verified',
        'id_verified_at',
        'id_verification_status',
        'stripe_identity_session_id',
        'producer_verified',
        'producer_badge_status',
        'producer_credit_url',
        'publisher_verified',
        'publisher_badge_status',
        'publisher_company_number',
        'publisher_verified_domain',
        'bio_ai_flagged',
        'joining_fee_paid',
        'joining_fee_paid_at',
        'status',
        'suspension_reason',
        'report_count',
        'onboarding_step',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'       => 'datetime',
            'id_verified'             => 'boolean',
            'id_verified_at'          => 'datetime',
            'producer_verified'       => 'boolean',
            'publisher_verified'      => 'boolean',
            'joining_fee_paid'        => 'boolean',
            'joining_fee_paid_at'     => 'datetime',
            'subscription_expires_at' => 'datetime',
            'is_admin'                => 'boolean',
            'password'                => 'hashed',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    // Relationships

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function portfolioItems()
    {
        return $this->hasMany(PortfolioItem::class);
    }

    public function sentConnections()
    {
        return $this->hasMany(Connection::class, 'requester_id');
    }

    public function receivedConnections()
    {
        return $this->hasMany(Connection::class, 'recipient_id');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
            ->withPivot('last_read_at');
    }

    public function briefs()
    {
        return $this->hasMany(Brief::class);
    }

    public function briefApplications()
    {
        return $this->hasMany(BriefApplication::class, 'applicant_id');
    }

    public function verificationLogs()
    {
        return $this->hasMany(VerificationLog::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reported_user_id');
    }

    public function promotedProfiles()
    {
        return $this->hasMany(PromotedProfile::class);
    }

    public function credits()
    {
        return $this->hasMany(\App\Models\Credit::class);
    }

    // Helpers

    public function isPro(): bool
    {
        return in_array($this->subscription_tier, ['pro', 'pro_plus'])
            && ($this->subscription_expires_at === null || $this->subscription_expires_at->isFuture());
    }

    public function isProPlus(): bool
    {
        return $this->subscription_tier === 'pro_plus'
            && ($this->subscription_expires_at === null || $this->subscription_expires_at->isFuture());
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isVerified(): bool
    {
        return $this->id_verified && $this->isActive();
    }
}
