<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('club_trophies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained('clubs')->onDelete('cascade');
            $table->foreignId('league_id')->constrained('leagues')->onDelete('cascade');
            $table->integer('year')->nullable(); // Anno del titolo
            $table->string('season')->nullable(); // Stagione (es: "2024/2025")
            $table->integer('count')->default(1); // Numero di titoli di questo tipo
            $table->string('image_url')->nullable(); // Immagine del trofeo
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indici
            $table->unique(['club_id', 'league_id', 'year']);
            $table->index('club_id');
            $table->index('league_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_trophies');
    }
};
