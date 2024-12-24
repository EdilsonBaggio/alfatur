<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('historicos', function (Blueprint $table) {
            $table->bigInteger('pktId')->default(0)->after('alerta_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historicos', function (Blueprint $table) {
            $table->dropColumn('pktId');
        });
    }
};
