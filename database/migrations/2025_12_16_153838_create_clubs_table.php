<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();

            // Identificazione
            $table->string('full_name');
            $table->string('short_name');
            $table->string('commercial_name')->nullable();
            $table->json('nicknames')->nullable();

            // Fondazione
            $table->date('founded_date')->nullable();
            $table->integer('estimated_fans')->default(0);

            // Localizzazione
            $table->foreignId('club_country_id')->constrained('countries')->onDelete('cascade');
            $table->string('city');
            $table->string('region')->nullable();
            $table->string('country_code', 2)->nullable();

            // Media
            $table->string('club_logo');
            $table->json('club_colors')->nullable(); // ["#0055A4", "#FFFFFF", "#EF4135"]

            // Organizzazione
            $table->string('club_president')->nullable();
            $table->string('club_ceo')->nullable();
            $table->string('club_sporting_director')->nullable();
            $table->string('club_team_manager')->nullable();
            $table->string('club_owner')->nullable();
            $table->string('club_owning_company')->nullable();
            $table->decimal('club_value', 15, 2)->nullable();

            // Sedi
            $table->string('club_headquarters')->nullable();
            $table->string('club_training_ground_name')->nullable();
            $table->string('club_training_ground_address')->nullable();

            // Staff tecnico
            $table->string('club_head_coach')->nullable();
            $table->json('club_assistant_coaches')->nullable();
            $table->string('club_fitness_coach')->nullable();
            $table->string('club_goalkeeper_coach')->nullable();
            $table->string('team_doctor')->nullable();
            $table->json('physiotherapists')->nullable();

            // Squadra
            $table->foreignId('captain_id')->nullable()->constrained('players')->onDelete('set null');
            $table->foreignId('vice_captain_id')->nullable()->constrained('players')->onDelete('set null');
            $table->decimal('average_age', 4, 1)->nullable();
            $table->decimal('squad_market_value', 15, 2)->nullable();

            // Palmares (saranno relazioni separate, qui solo conteggi)
            $table->integer('league_titles_count')->default(0);
            $table->integer('domestic_cups_count')->default(0);
            $table->integer('domestic_supercups_count')->default(0);
            $table->integer('champions_leagues_count')->default(0);
            $table->integer('europa_leagues_count')->default(0);
            $table->integer('conference_leagues_count')->default(0);
            $table->integer('international_cups_count')->default(0);

            // Record
            $table->string('best_league_finish')->nullable();
            $table->string('worst_league_finish')->nullable();
            $table->string('best_season_year')->nullable();
            $table->integer('consecutive_wins_record')->default(0);
            $table->integer('unbeaten_record')->default(0);
            $table->integer('goals_record_season')->default(0);
            $table->string('biggest_win')->nullable(); // "10-0 vs..."
            $table->string('biggest_defeat')->nullable();

            // Sponsor e commerciale
            $table->string('main_sponsor')->nullable();
            $table->string('kit_manufacturer')->nullable();
            $table->string('official_website')->nullable();
            $table->string('official_app')->nullable();

            // Giocatori icona (per ora come JSON, poi relazione)
            $table->json('icon_players')->nullable();

            // Collegamenti
            $table->foreignId('stadium_id')->nullable()->constrained('stadiums')->onDelete('set null');
            $table->foreignId('current_league_id')->nullable()->constrained('leagues')->onDelete('set null');

            // Stato
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indici
            $table->index('club_country_id');
            $table->index('city');
            $table->index('current_league_id');
            $table->unique(['full_name', 'club_country_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
