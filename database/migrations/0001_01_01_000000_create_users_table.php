<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['songwriter', 'composer', 'producer', 'publisher', 'other'])->default('songwriter');
            $table->string('phone')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->enum('subscription_tier', ['free', 'pro', 'pro_plus'])->default('free');
            $table->timestamp('subscription_expires_at')->nullable();
            $table->enum('subscription_term', ['annual', 'six_month', 'three_month'])->nullable();
            $table->boolean('id_verified')->default(false);
            $table->timestamp('id_verified_at')->nullable();
            $table->enum('id_verification_status', ['pending', 'passed', 'failed', 'review'])->nullable();
            $table->string('stripe_identity_session_id')->nullable();
            $table->boolean('producer_verified')->default(false);
            $table->boolean('publisher_verified')->default(false);
            $table->boolean('joining_fee_paid')->default(false);
            $table->timestamp('joining_fee_paid_at')->nullable();
            $table->enum('status', ['pending', 'active', 'suspended', 'banned'])->default('pending');
            $table->text('suspension_reason')->nullable();
            $table->unsignedInteger('report_count')->default(0);
            $table->unsignedTinyInteger('onboarding_step')->default(1);
            $table->boolean('is_admin')->default(false);
            // Two-factor auth (Fortify)
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
