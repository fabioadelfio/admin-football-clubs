<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();

            // Informazioni anagrafiche
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name')->virtualAs('CONCAT(first_name, " ", last_name)');
            $table->date('date_of_birth');
            $table->string('birth_place')->nullable();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->integer('age')->virtualAs('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE())');

            // Informazioni fisiche
            $table->integer('height')->nullable(); // in cm
            $table->integer('weight')->nullable(); // in kg
            $table->enum('preferred_foot', ['RIGHT', 'LEFT', 'BOTH'])->nullable();

            // Ruolo e posizione
            $table->string('primary_position'); // "Attaccante", "Centrocampista", etc.
            $table->json('secondary_positions')->nullable(); // ["Ala sinistra", "Trequartista"]
            $table->string('specific_role')->nullable(); // "Punta centrale", "Mediano", etc.
            $table->integer('jersey_number')->nullable();

            // Collegamenti
            $table->foreignId('current_club_id')->nullable()->constrained('clubs')->onDelete('set null');

            // Media e link
            $table->string('player_img')->nullable();
            $table->string('transfermarkt_link')->nullable();
            $table->string('ig_link')->nullable();

            // Dati professionali
            $table->decimal('market_value', 12, 2)->nullable();
            $table->date('contract_expiry')->nullable();
            $table->string('agent')->nullable();

            // Statistiche (annuali, potranno essere in tabella separata)
            $table->integer('total_appearances')->default(0);
            $table->integer('total_goals')->default(0);
            $table->integer('total_assists')->default(0);

            // Stato
            $table->enum('status', ['ACTIVE', 'INJURED', 'SUSPENDED', 'RETIRED', 'FREE_AGENT'])->default('ACTIVE');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indici
            $table->index('country_id');
            $table->index('current_club_id');
            $table->index('primary_position');
            $table->index('date_of_birth');
            $table->index('last_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
