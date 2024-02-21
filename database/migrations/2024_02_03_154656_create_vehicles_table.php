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
            Schema::create('vehicles', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('category_id')->unsigned();
                $table->bigInteger('brand_id')->nullable();
                $table->string('name')->nullable();
                $table->string('model')->nullable();
                $table->string('year')->nullable();
                $table->string('color')->nullable();
                $table->string('license_plate')->nullable();
                $table->string('chassis_number')->nullable();
                $table->string('engine_number')->nullable();
                $table->string('purchase_date')->nullable();
                $table->string('purchase_price')->nullable();
                $table->enum('status', [
                    'active',
                    'inactive',
                    'under_maintanance'
                ])->nullable(); // active, inactive, under_maintanance
    
                $table->timestamps();
            });

    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
