<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('event', [
                'id_check_started',
                'id_check_passed',
                'id_check_failed',
                'producer_badge_granted',
                'publisher_badge_granted',
                'account_suspended',
                'account_reinstated',
                'report_received',
                'message_flagged',
            ]);
            $table->json('detail')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_logs');
    }
};
