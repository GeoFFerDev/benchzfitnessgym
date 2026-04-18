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
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('checked_in_at');
            $table->timestamps();
        });

        $members = DB::table('users')
            ->where('role', 'member')
            ->select('id')
            ->get();

        $seededLogs = [];

        foreach ($members as $member) {
            $seededLogs[] = [
                'user_id' => $member->id,
                'checked_in_at' => now()->setTime(7, 30),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $seededLogs[] = [
                'user_id' => $member->id,
                'checked_in_at' => now()->subDays(2)->setTime(18, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $seededLogs[] = [
                'user_id' => $member->id,
                'checked_in_at' => now()->subDays(6)->setTime(6, 45),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $seededLogs[] = [
                'user_id' => $member->id,
                'checked_in_at' => now()->subDays(13)->setTime(17, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (! empty($seededLogs)) {
            DB::table('attendance_logs')->insert($seededLogs);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};
