<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->where('username', 'admin')
            ->update([
                'password' => Hash::make('Qaz123'),
                'updated_at' => now(),
            ]);
    }

    public function down(): void {}
};
