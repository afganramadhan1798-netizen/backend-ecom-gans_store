<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->where('role', 'user')
            ->update(['role' => 'customer']);

        DB::statement("
            ALTER TABLE users
            MODIFY role VARCHAR(255) NOT NULL DEFAULT 'customer'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role VARCHAR(255) NOT NULL DEFAULT 'user'
        ");

        DB::table('users')
            ->where('role', 'customer')
            ->update(['role' => 'user']);
    }
};