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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            //set default a unique id
            $table->string('guest_id')->nullable();
            $table->string('guest_name');
            $table->string('guest_number');
            $table->string('room_id');
            $table->boolean('checked')->default(false);
            $table->date('arrive_date');
            $table->date('leave_date');
            $table->boolean('is_cancel')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('bookings');
    }
};
