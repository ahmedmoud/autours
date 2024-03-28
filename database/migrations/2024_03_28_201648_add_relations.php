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
       Schema::table('branches', function (Blueprint $table){
           $table->bigInteger('company_id')->change();
       });

        Schema::drop('membership_requests');

        Schema::table('profits', function (Blueprint $table){
            $table->bigInteger('supplier_id')->change();
            $table->bigInteger('vehicle_id')->change();
            $table->bigInteger('branch_id')->change();

        });

        Schema::table('rentals', function (Blueprint $table){
            $table->bigInteger('customer_id')->change();
            $table->bigInteger('order_status')->change();
            $table->bigInteger('vehicle_id')->change();

        });

        Schema::table('supplier_rental_terms', function (Blueprint $table){
            $table->bigInteger('rental_term_id')->change();
            $table->bigInteger('supplier_id')->change();

        });
        Schema::table('vehicle_included', function (Blueprint $table){
            $table->bigInteger('included_id')->change();
            $table->bigInteger('vehicle_id')->change();
        });
        Schema::table('vehicles', function (Blueprint $table){
            $table->bigInteger('supplier')->change();
            $table->bigInteger('category')->change();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
