<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            // Add new fields
            $table->string('payment_method')->after('status')->nullable();
            $table->text('notes')->after('payment_method')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            // Remove new fields
            $table->dropColumn(['payment_method', 'notes']);
        });
    }
};