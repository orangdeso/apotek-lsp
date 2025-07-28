<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id('id_cart');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_obat');
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Harga saat ditambahkan ke cart
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_obat')->references('id_obat')->on('obat')->onDelete('cascade');
            
            // Unique constraint untuk mencegah duplikasi item yang sama dari user yang sama
            $table->unique(['user_id', 'id_obat']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};