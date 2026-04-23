<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
// $table->foreignId('category_id')->nullable()->after('name')->constrained()->onDelete('set null'); // already exists
            $table->string('barcode')->nullable()->unique()->after('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'barcode']);
        });
    }
};

