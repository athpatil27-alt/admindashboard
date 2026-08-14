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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('teacher')->after('email'); // admin, teacher, editor, creator
            $table->string('status')->default('active')->after('role'); // active, inactive, suspended
            $table->string('phone')->nullable()->after('status');
            $table->text('bio')->nullable()->after('phone');
            $table->string('avatar_url')->nullable()->after('bio');
            $table->timestamp('last_login_at')->nullable()->after('avatar_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'phone', 'bio', 'avatar_url', 'last_login_at']);
        });
    }
};
