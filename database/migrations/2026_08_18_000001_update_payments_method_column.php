<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('method', 50)->default('tunai')->change();
        });

        DB::table('payments')->whereIn('method', ['midtrans', 'online'])->update(['method' => 'online']);
        DB::table('payments')->whereIn('method', ['manual', 'tunai'])->update(['method' => 'tunai']);
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('method', 50)->default('manual')->change();
        });
    }
};
