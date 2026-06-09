<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('saisons', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->timestamps();
        });

        Schema::create('saison_vetement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vetement_id')->constrained('vetements')->onDelete('cascade');
            $table->foreignId('saison_id')->constrained('saisons')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('vetements', function (Blueprint $table) {
            $table->dropColumn('saison');
        });
    }

    public function down(): void
    {
        Schema::table('vetements', function (Blueprint $table) {
            $table->string('saison')->nullable();
        });

        Schema::dropIfExists('saison_vetement');
        Schema::dropIfExists('saisons');
    }
};