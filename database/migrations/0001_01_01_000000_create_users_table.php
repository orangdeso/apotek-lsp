<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('alamat');
            $table->string('kota');
            $table->string('telpon');
            $table->enum('role', ['admin', 'apoteker', 'pelanggan'])->default('pelanggan');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('alamat')->after('email');
            $table->string('kota')->after('alamat');
            $table->string('telpon')->after('kota');
            $table->enum('role', ['admin', 'apoteker', 'pelanggan'])->default('pelanggan')->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'kota', 'telpon', 'role']);
        });
    }
};
