<?php

declare(strict_types=1);

use App\Infrastructure\Persistence\SchemaContexto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('username')->nullable()->unique()->after('name');
            $table->boolean('eh_administrador')->default(false)->after('password');
        });

        if (SchemaContexto::suportaSchema()) {
            DB::statement('CREATE SCHEMA IF NOT EXISTS pessoas');
        }

        $perfis = SchemaContexto::tabela('pessoas', 'perfis');
        $colaboradorPerfis = SchemaContexto::tabela('pessoas', 'colaborador_perfis');
        $perfilPermissoes = SchemaContexto::tabela('pessoas', 'perfil_permissoes');

        Schema::create($perfis, function (Blueprint $table): void {
            $table->id();
            $table->uuid('prf_uuid')->unique();
            $table->string('nome')->unique();
            $table->timestamps();
        });

        Schema::create($perfilPermissoes, function (Blueprint $table) use ($perfis): void {
            $table->foreignId('perfil_id')->constrained($perfis)->cascadeOnDelete();
            $table->string('permissao');
            $table->unique(['perfil_id', 'permissao']);
        });

        Schema::create($colaboradorPerfis, function (Blueprint $table) use ($perfis): void {
            $table->uuid('colaborador_id');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores')
                ->cascadeOnDelete();
            $table->foreignId('perfil_id')->constrained($perfis)->cascadeOnDelete();
            $table->unique(['colaborador_id', 'perfil_id']);
        });

        DB::table('users')->updateOrInsert(
            ['username' => 'admin'],
            [
                'name' => 'Administrador',
                'email' => 'admin@olympus.local',
                'password' => Hash::make('Qaz123'),
                'eh_administrador' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(SchemaContexto::tabela('pessoas', 'colaborador_perfis'));
        Schema::dropIfExists(SchemaContexto::tabela('pessoas', 'perfil_permissoes'));
        Schema::dropIfExists(SchemaContexto::tabela('pessoas', 'perfis'));
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['username', 'eh_administrador']);
        });
    }
};
