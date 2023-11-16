<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jornada_laborals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->date('fecha_inicio');
            $table->time('hora_inicio');
            $table->date('fecha_fin')->nullable();
            $table->time('hora_fin')->nullable();
            $table->string('ubicacion_inicio');
            $table->string('ubicacion_fin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jornada_laborals');
    }
};
