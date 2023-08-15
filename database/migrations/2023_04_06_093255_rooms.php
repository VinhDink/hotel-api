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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('hour_price');
            $table->string('day_price');
            $table->boolean('status');
            $table->integer('size');
            $table->boolean('balcony');
            $table->string('view');
            $table->boolean('smoking');
            $table->integer('floor');
            $table->boolean('bathtub');
            $table->string('image_first')->nullable();
            $table->string('image_second')->nullable();
            $table->string('image_third')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('rooms');
    }
};
