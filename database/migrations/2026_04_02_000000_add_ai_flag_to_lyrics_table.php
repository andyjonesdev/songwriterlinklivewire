<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lyrics', function (Blueprint $table) {
            $table->boolean('ai_flagged')->nullable()->after('social_used');
            $table->text('ai_flag_reason')->nullable()->after('ai_flagged');
        });
    }

    public function down(): void
    {
        Schema::table('lyrics', function (Blueprint $table) {
            $table->dropColumn(['ai_flagged', 'ai_flag_reason']);
        });
    }
};
