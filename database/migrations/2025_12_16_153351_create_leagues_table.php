<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leagues', function (Blueprint $table) {
            $table->id();

            // Informazioni base
            $table->string('league_name');
            $table->string('league_short_name');
            $table->string('league_official_name')->nullable();
            $table->string('league_code')->unique();
            $table->enum('league_type', ['DOMESTIC_LEAGUE', 'DOMESTIC_CUP', 'DOMESTIC_SUPERCUP', 'CONTINENTAL_CLUB', 'CONTINENTAL_NATIONAL', 'WORLD_CLUB', 'WORLD_NATIONAL', 'YOUTH', 'WOMEN', 'OTHER'])->default('DOMESTIC_LEAGUE');

            // Localizzazione
            $table->foreignId('league_country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->string('league_continent')->nullable();

            // Media e identificazione
            $table->string('league_logo_img')->nullable();
            $table->string('league_trophy_img')->nullable();

            // Organizzazione
            $table->string('league_organizer')->nullable();
            $table->year('league_founded_year')->nullable();
            $table->string('league_first_season')->nullable();
            $table->string('league_headquarters')->nullable();
            $table->string('league_president')->nullable();
            $table->string('league_ceo')->nullable();
            $table->string('league_website')->nullable();

            // Formato e struttura
            $table->integer('teams_count')->default(0);
            $table->string('league_format')->nullable();
            $table->integer('total_matches')->default(0);
            $table->integer('matchdays')->default(0);

            // Record e palmares
            $table->foreignId('most_titles_team_id')->nullable()->constrained('clubs')->onDelete('set null');
            $table->integer('most_titles_count')->default(0);
            $table->integer('points_record')->default(0);
            $table->foreignId('points_record_team_id')->nullable()->constrained('clubs')->onDelete('set null');
            $table->string('points_record_season')->nullable();
            $table->integer('goals_record')->default(0);
            $table->foreignId('goals_record_team_id')->nullable()->constrained('clubs')->onDelete('set null');
            $table->string('all_time_top_scorer')->nullable();
            $table->integer('all_time_top_scorer_goals')->default(0);
            $table->string('appearances_record_holder')->nullable();
            $table->integer('appearances_record_count')->default(0);

            // Media
            $table->json('tv_broadcasters')->nullable();

            // Stato
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indici
            $table->index('league_country_id');
            $table->index('league_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leagues');
    }
};
