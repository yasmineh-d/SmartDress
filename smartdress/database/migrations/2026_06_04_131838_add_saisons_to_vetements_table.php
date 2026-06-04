<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('vetements', function (Blueprint $table) {
            // On stocke les saisons sous forme de tableau JSON (ex: ["printemps", "ete"])
            $table->json('saisons')->nullable()->after('categorie');
        });
    }

    public function down(): void
    {
        Schema::table('vetements', function (Blueprint $table) {
            $table->dropColumn('saisons');
        });
    }
};