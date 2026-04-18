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
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedInteger('duration_value');
            $table->string('duration_unit', 20);
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        DB::table('membership_plans')->insert([
            [
                'name' => 'Bronze',
                'duration_value' => 1,
                'duration_unit' => 'day',
                'price' => 200.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Silver',
                'duration_value' => 7,
                'duration_unit' => 'days',
                'price' => 700.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gold',
                'duration_value' => 30,
                'duration_unit' => 'days',
                'price' => 1500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_plans');
    }
};
