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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('nev');
            $table->string('bpkod')->unique();
            $table->foreignId('type_id')->constrained('device_types')->onUpdate('cascade')->onDelete('cascade');
            $table->string('movexkod')->nullable();
            $table->string('uzem');
            $table->string('uzemterulet')->nullable();
            $table->boolean('aktiv')->default(false);
            $table->string('tortenet')->nullable();
            $table->string('megjegyzes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
