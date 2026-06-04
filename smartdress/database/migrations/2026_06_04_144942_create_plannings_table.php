<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vetement_top_id')->constrained('vetements')->onDelete('cascade');
            $table->foreignId('vetement_bottom_id')->constrained('vetements')->onDelete('cascade');
            $table->date('date_planning'); // Enregistre le jour exact (ex: aujourd'hui)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plannings');
    }
};