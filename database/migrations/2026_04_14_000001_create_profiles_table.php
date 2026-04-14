<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('display_name')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('country')->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->boolean('profile_photo_flagged')->default(false);
            $table->json('genres')->nullable();
            $table->json('social_links')->nullable();
            $table->boolean('is_searchable')->default(true);
            $table->unsignedTinyInteger('search_boost_weight')->default(1);
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('connections_count')->default(0);
            $table->boolean('ai_bio_flagged')->default(false);
            $table->float('ai_bio_confidence')->nullable();
            $table->text('ai_bio_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
