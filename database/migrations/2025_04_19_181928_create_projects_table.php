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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('project_category_id')->constrained()->onDelete('restrict');
            $table->foreignId('project_status_id')->constrained()->onDelete('restrict');
            $table->date('submission_date');
            $table->date('deadline_for_corrections')->nullable();
            $table->decimal('final_score', 5, 2)->nullable()->comment('Calculated from evaluations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
