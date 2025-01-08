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
        Schema::create('orangs', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('nik', 50);
            $table->string('nama', 50);
            $table->string('email', 50);
            $table->string('nohp', 15);
            $table->string('alamat', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orangs');
    }
};
