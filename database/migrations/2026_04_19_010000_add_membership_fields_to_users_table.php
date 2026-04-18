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
            $table->foreignId('membership_plan_id')->nullable()->after('role')->constrained('membership_plans')->nullOnDelete();
            $table->string('membership_status')->default('active')->after('membership_plan_id');
            $table->timestamp('plan_expires_at')->nullable()->after('membership_status');
        });

        $defaultPlan = DB::table('membership_plans')
            ->orderBy('price')
            ->first();

        if ($defaultPlan) {
            $expiry = match ($defaultPlan->duration_unit) {
                'day', 'days' => now()->addDays((int) $defaultPlan->duration_value),
                'week', 'weeks' => now()->addWeeks((int) $defaultPlan->duration_value),
                'month', 'months' => now()->addMonths((int) $defaultPlan->duration_value),
                'year', 'years' => now()->addYears((int) $defaultPlan->duration_value),
                default => now()->addDays((int) $defaultPlan->duration_value),
            };

            DB::table('users')
                ->where('role', 'member')
                ->update([
                    'membership_plan_id' => $defaultPlan->id,
                    'membership_status' => 'active',
                    'plan_expires_at' => $expiry,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('membership_plan_id');
            $table->dropColumn(['membership_status', 'plan_expires_at']);
        });
    }
};
