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
        Schema::create('meat_cut_outputs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('meat_intake_item_id');
            $table->foreign('meat_intake_item_id')->references('id')->on('meat_intake_items');
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->decimal('amount', 8, 2)->nullable();
            $table->decimal('total_weight_kg', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meat_cut_outputs');
    }
};
