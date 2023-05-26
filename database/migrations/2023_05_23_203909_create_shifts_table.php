<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('worker')->constrained()->cascadeOnDelete();
            $table->foreignId('company')->constrained()->cascadeOnDelete();
            $table->float('hours');
            $table->float('rate_per_hour');
            $table->boolean('taxable');
            $table->string('status');
            $table->string('shift_type');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
