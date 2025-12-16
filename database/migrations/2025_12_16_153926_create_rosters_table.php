<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rosters', function (Blueprint $table) {
            $table->id();
            $table->string('season'); // "2025/2026"
            $table->foreignId('club_id')->constrained('clubs')->onDelete('cascade');
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');

            // Dati specifici per questa stagione con questo club
            $table->integer('jersey_number')->nullable();
            $table->string('position')->nullable();
            $table->date('joined_date')->nullable();
            $table->date('contract_expiry')->nullable();
            $table->decimal('salary', 12, 2)->nullable();
            $table->decimal('market_value', 12, 2)->nullable();
            $table->boolean('is_loan')->default(false);
            $table->foreignId('loan_from_club_id')->nullable()->constrained('clubs');
            $table->date('loan_end_date')->nullable();

            // Statistiche per questa stagione
            $table->integer('appearances')->default(0);
            $table->integer('starts')->default(0);
            $table->integer('minutes_played')->default(0);
            $table->integer('goals')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('yellow_cards')->default(0);
            $table->integer('red_cards')->default(0);

            // Stato
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indici
            $table->unique(['season', 'club_id', 'player_id']);
            $table->index('season');
            $table->index('club_id');
            $table->index('player_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rosters');
    }
};
