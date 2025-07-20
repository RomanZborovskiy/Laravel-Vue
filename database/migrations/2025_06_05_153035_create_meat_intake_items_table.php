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
        Schema::create('meat_intake_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('intake_id');
            $table->foreign('intake_id')->references('id')->on('intake_meats');
            $table->unsignedInteger('type_id');
            $table->foreign('type_id')->references('id')->on('meat_types');
            $table->unsignedInteger('part_id');
            $table->foreign('part_id')->references('id')->on('meat_parts');
            $table->decimal('quantity',8,2);
            $table->boolean('status')->default('false');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meat_intake_items');
    }
};
