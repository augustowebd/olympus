<?php

use App\Infrastructure\Persistence\SchemaContexto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(SchemaContexto::tabela('producao', 'nucleos'), function (Blueprint $table) {
            $table->unique('nome');
        });
    }

    public function down(): void
    {
        Schema::table(SchemaContexto::tabela('producao', 'nucleos'), function (Blueprint $table) {
            $table->dropUnique(['nome']);
        });
    }
};
