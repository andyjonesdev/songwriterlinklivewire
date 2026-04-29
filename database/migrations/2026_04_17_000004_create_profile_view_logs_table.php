<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_view_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->date('viewed_on');
            $table->unsignedInteger('view_count')->default(1);
            $table->unique(['profile_id', 'viewed_on']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_view_logs');
    }
};
