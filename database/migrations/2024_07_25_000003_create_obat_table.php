<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obat', function (Blueprint $table) {
            $table->id('id_obat');
            $table->string('name_obat');
            $table->string('type');
            $table->string('unit');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->integer('stok');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->date('expdate');
            $table->unsignedBigInteger('id_supplier');
            $table->timestamps();
            
            $table->foreign('id_supplier')->references('id_supplier')->on('supplier')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};