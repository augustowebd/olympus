<?php

use App\Infrastructure\Persistence\SchemaContexto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (SchemaContexto::suportaSchema()) {
            DB::statement('CREATE SCHEMA IF NOT EXISTS producao');
        }

        Schema::create(SchemaContexto::tabela('producao', 'nucleos'), function (Blueprint $table) {
            $table->id();
            $table->uuid('ncl_uuid')->unique();
            $table->string('nome');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(SchemaContexto::tabela('producao', 'nucleos'));
    }
};
