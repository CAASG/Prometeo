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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('evaluation_phase_id')->constrained()->onDelete('restrict');
            $table->decimal('total_score', 5, 2)->nullable();
            $table->text('comments')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->timestamp('evaluation_date')->nullable();
            $table->timestamps();
            
            $table->unique(['project_id', 'evaluator_id', 'evaluation_phase_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
