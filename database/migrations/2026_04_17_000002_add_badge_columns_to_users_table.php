<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('producer_badge_status', ['none', 'pending', 'approved', 'rejected'])->default('none')->after('producer_verified');
            $table->string('producer_credit_url')->nullable()->after('producer_badge_status');
            $table->enum('publisher_badge_status', ['none', 'pending', 'approved', 'rejected'])->default('none')->after('publisher_verified');
            $table->string('publisher_company_number')->nullable()->after('publisher_badge_status');
            $table->string('publisher_verified_domain')->nullable()->after('publisher_company_number');
            $table->boolean('bio_ai_flagged')->default(false)->after('suspension_reason');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'producer_badge_status',
                'producer_credit_url',
                'publisher_badge_status',
                'publisher_company_number',
                'publisher_verified_domain',
                'bio_ai_flagged',
            ]);
        });
    }
};
