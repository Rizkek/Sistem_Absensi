<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations untuk optimize query performance
     */
    public function up(): void
    {
        // Add indexes untuk faster queries
        Schema::table('students', function (Blueprint $table) {
            $table->index('group_id');
            $table->index('nis');
            $table->index('name');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->index('mentor_id');
            $table->index('name');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->index('group_id');
            $table->index('status');
            $table->index('start_time');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->index('student_id');
            $table->index('session_id');
            $table->index('status');
            $table->index('created_at');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
            $table->index('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['group_id']);
            $table->dropIndex(['nis']);
            $table->dropIndex(['name']);
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->dropIndex(['mentor_id']);
            $table->dropIndex(['name']);
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropIndex(['group_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['start_time']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['student_id']);
            $table->dropIndex(['session_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['role']);
        });
    }
};
