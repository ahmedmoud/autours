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
        DB::insert("INSERT INTO currencies (name, country, flag)
                          VALUES
                              ('SAR','Kingdom of Saudi Arabia', 'SA' ),
                              ('QAR','Qatar', 'QA' ),
                              ('OMR','Oman', 'OM' ),
                              ('KWD','Kuwait', 'KW' ),
                              ('BHD','Bahrain', 'BH' )
                                 ;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
