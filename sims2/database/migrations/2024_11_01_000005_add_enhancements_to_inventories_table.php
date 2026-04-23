<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->integer('spoiled_stock')->default(0)->after('stock');
            $table->integer('low_stock_threshold')->default(10)->after('spoiled_stock');
            $table->foreignId('updated_by')->nullable()->after('updated_at')->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['spoiled_stock', 'low_stock_threshold', 'updated_by']);
        });
    }
};

