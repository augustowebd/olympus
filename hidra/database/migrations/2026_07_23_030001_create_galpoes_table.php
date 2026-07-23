<?php

use App\Infrastructure\Persistence\SchemaContexto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(SchemaContexto::tabela('producao', 'galpoes'), function (Blueprint $table) {
            $table->id();
            $table->uuid('glp_uuid')->unique();
            $table->string('nome');
            $table->string('slug')->unique();
            $table->unsignedInteger('capacidade');
            $table->foreignId('nucleo_id')->constrained(SchemaContexto::tabela('producao', 'nucleos'))->restrictOnDelete();
            $table->string('status')->default('DESOCUPADO');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(SchemaContexto::tabela('producao', 'galpoes'));
    }
};
