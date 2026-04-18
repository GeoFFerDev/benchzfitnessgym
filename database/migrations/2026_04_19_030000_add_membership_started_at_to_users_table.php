<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('membership_started_at')->nullable()->after('plan_expires_at');
        });

        DB::table('users')
            ->where('role', 'member')
            ->whereNotNull('membership_plan_id')
            ->update([
                'membership_started_at' => DB::raw('COALESCE(created_at, NOW())'),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('membership_started_at');
        });
    }
};
