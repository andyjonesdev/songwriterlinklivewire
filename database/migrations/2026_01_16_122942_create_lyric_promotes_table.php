<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lyric_promotes', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_session_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lyric_id')->constrained()->onDelete('cascade');
            $table->string('placement')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('bid', 8, 2);
            $table->decimal('amount', 10, 2);
            $table->datetime('starts_at');
            $table->datetime('ends_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lyric_promotes');
    }
};
