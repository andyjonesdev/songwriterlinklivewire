<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('briefs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['co_writer', 'topline', 'sync_placement', 'ghost_write', 'session_lyricist']);
            $table->json('genres')->nullable();
            $table->enum('compensation_type', ['split', 'fee', 'spec']);
            $table->string('compensation_detail')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('status', ['open', 'closed', 'expired'])->default('open');
            $table->timestamp('expires_at')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->timestamps();
        });

        Schema::create('brief_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brief_id')->constrained()->cascadeOnDelete();
            $table->foreignId('applicant_id')->constrained('users')->cascadeOnDelete();
            $table->text('pitch_text');
            $table->foreignId('portfolio_item_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['pending', 'shortlisted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->unique(['brief_id', 'applicant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brief_applications');
        Schema::dropIfExists('briefs');
    }
};
