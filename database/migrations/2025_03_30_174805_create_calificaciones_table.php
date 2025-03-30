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
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
            $table->foreignId('evaluador_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipo', ['escrita', 'oral', 'final']);
            $table->decimal('puntaje', 2, 1)->check('puntaje >= 0 AND puntaje <= 5');
            $table->text('observaciones')->nullable();
            $table->timestamp('fecha_evaluacion')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
