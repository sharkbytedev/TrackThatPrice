<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('product_users', 'product_user');
    }

    public function down(): void
    {
        Schema::rename('product_user', 'product_users');
    }
};