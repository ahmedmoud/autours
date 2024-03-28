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
           $table->foreign('company_id')->references('id')->on('users');
       });

        Schema::drop('membership_requests');

        Schema::table('profits', function (Blueprint $table){
            $table->bigInteger('supplier_id')->change();
            $table->bigInteger('vehicle_id')->change();
            $table->bigInteger('branch_id')->change();

            $table->foreign('supplier_id')->references('id')->on('users');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('branch_id')->references('id')->on('branches');
        });

        Schema::table('rentals', function (Blueprint $table){
            $table->bigInteger('customer_id')->change();
            $table->bigInteger('order_status')->change();
            $table->bigInteger('vehicle_id')->change();
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('order_status')->references('id')->on('rental_statuses');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
        });

        Schema::table('supplier_rental_terms', function (Blueprint $table){
            $table->bigInteger('rental_term_id')->change();
            $table->bigInteger('supplier_id')->change();
            $table->foreign('rental_term_id')->references('id')->on('rental_terms');
            $table->foreign('supplier_id')->references('id')->on('users');
        });
        Schema::table('vehicle_included', function (Blueprint $table){
            $table->bigInteger('included_id')->change();
            $table->bigInteger('vehicle_id')->change();
            $table->foreign('included_id')->references('id')->on('included');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
        });
        Schema::table('vehicles', function (Blueprint $table){
            $table->bigInteger('supplier')->change();
            $table->bigInteger('category')->change();
            $table->foreign('supplier')->references('id')->on('users');
            $table->foreign('category')->references('id')->on('categories');
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
