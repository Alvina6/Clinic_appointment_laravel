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
        Schema::create('appointments', function (Blueprint $table) {
             $table->id();

            // Patient (User)
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Doctor
            $table->foreignId('doctor_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Appointment date & time
            $table->date('appointment_date');
            $table->time('appointment_time');

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'completed',
                'cancelled'
            ])->default('pending');

            
            $table->text('reason')->nullable();

            $table->timestamps();

            
            $table->unique([
                'doctor_id',
                'appointment_date',
                'appointment_time'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
