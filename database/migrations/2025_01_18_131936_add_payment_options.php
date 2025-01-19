<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        DB::table('payment_methods')->insert(['name' => 'Cash at Desk', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('payment_methods')->insert(['name' => 'Full Payment', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('payment_methods')->insert(['name' => 'Partial Payment', 'created_at' => now(), 'updated_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
