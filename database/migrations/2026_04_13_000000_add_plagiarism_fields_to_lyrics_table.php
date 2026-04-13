<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lyrics', function (Blueprint $table) {
            $table->boolean('plagiarism_flagged')->nullable()->after('ai_approved');
            $table->string('plagiarism_match_url')->nullable()->after('plagiarism_flagged');
            $table->text('plagiarism_flag_reason')->nullable()->after('plagiarism_match_url');
        });
    }

    public function down(): void
    {
        Schema::table('lyrics', function (Blueprint $table) {
            $table->dropColumn(['plagiarism_flagged', 'plagiarism_match_url', 'plagiarism_flag_reason']);
        });
    }
};
