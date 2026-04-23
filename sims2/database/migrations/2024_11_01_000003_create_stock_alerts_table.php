<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained()->onDelete('cascade');
            $table->string('alert_type'); // 'low_stock', 'high_spoilage'
            $table->integer('threshold_value');
            $table->timestamp('triggered_at')->useCurrent();
            $table->timestamp('resolved_at')->nullable();
            $table->json('notified_users')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_alerts');
    }
};

