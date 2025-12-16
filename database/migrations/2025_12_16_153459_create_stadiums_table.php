<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stadiums', function (Blueprint $table) {
            $table->id();

            // Informazioni base
            $table->string('stadium_name');
            $table->string('stadium_nickname')->nullable();

            // Localizzazione
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->string('city');
            $table->string('stadium_address')->nullable();
            $table->string('coordinates')->nullable(); // "45.4642,9.1900"

            // Capacità e record
            $table->integer('stadium_capacity')->default(0);
            $table->integer('attendance_record')->default(0);
            $table->date('attendance_record_date')->nullable();
            $table->integer('average_attendance')->default(0);

            // Dati tecnici
            $table->string('pitch_dimensions')->nullable(); // "105x68m"
            $table->enum('pitch_type', ['NATURAL_GRASS', 'HYBRID', 'ARTIFICIAL', 'DESSO'])->default('NATURAL_GRASS');
            $table->year('year_built')->nullable();
            $table->year('year_renovated')->nullable();

            // Media
            $table->string('stadium_img')->nullable();
            $table->json('gallery_images')->nullable();

            // Proprietà
            $table->string('owner')->nullable();
            $table->string('operator')->nullable();
            $table->decimal('cost', 15, 2)->nullable();

            // Stato
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indici
            $table->index('country_id');
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stadiums');
    }
};
