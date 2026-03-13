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
        Schema::create('tenue_vetement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenue_id')->constrained('tenues')->onDelete('cascade');
            $table->foreignId('vetement_id')->constrained('vetements')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenue_vetement');
    }
};
