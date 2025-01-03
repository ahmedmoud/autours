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
        Schema::table('rental_terms', function (Blueprint $table) {
            $table->integer('status')->index()->default(2);
            $table->unsignedBigInteger('created_by')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_terms', function (Blueprint $table) {
            //
        });
    }
};
