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
        Schema::create('spoilage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventories')->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->text('reason')->nullable();
            $table->timestamp('detected_at');
            $table->foreignId('detected_by')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('stock_before');
            $table->integer('stock_after');
            $table->integer('spoiled_before');
            $table->integer('spoiled_after');
            $table->enum('status', ['detected', 'refunded', 'disposed'])->default('detected');
            $table->foreignId('refund_sale_id')->nullable()->constrained('sales')->nullOnDelete();
            $table->timestamp('refund_processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spoilage_logs');
    }
};
