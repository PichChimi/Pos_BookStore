<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_activity_logs', function (Blueprint $table) {
            // Check if the 'email' column exists, if not add it
        if (!Schema::connection('oracle')->hasColumn('user_activity_logs', 'email')) {
            Schema::connection('oracle')->table('user_activity_logs', function (Blueprint $table) {
                $table->string('email')->nullable()->after('username');
            });
        }

        // Check if the 'role_id' column exists, if not add it
        if (!Schema::connection('oracle')->hasColumn('user_activity_logs', 'role_id')) {
            Schema::connection('oracle')->table('user_activity_logs', function (Blueprint $table) {
                $table->unsignedBigInteger('role_id')->nullable()->after('email');
            });
        }

        // Check if the 'created_at' column exists, if not add it
        if (!Schema::connection('oracle')->hasColumn('user_activity_logs', 'created_at')) {
            Schema::connection('oracle')->table('user_activity_logs', function (Blueprint $table) {
                $table->timestamp('created_at')->nullable()->after('user_agent');
            });
        }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_activity_logs', function (Blueprint $table) {
             $table->dropColumn('email');
             $table->dropColumn('role_id');
             $table->dropColumn('created_at_date');
        });
    }
};
