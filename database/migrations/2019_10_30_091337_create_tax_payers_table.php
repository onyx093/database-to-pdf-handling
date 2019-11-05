<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxPayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_payers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('official_name');
            $table->string('official_rin');
            $table->string('business_name');
            $table->string('business_rin');
            $table->string('address');
            $table->string('phone');

            $table->string('payer_rin');
            $table->string('payer_name');
            $table->string('start_month');
            $table->string('end_month');
            $table->double('gross_pay', 15, 2);
            $table->double('consolidated_relief_allowance', 15, 2);
            $table->double('pension_contribution_declared', 15, 2);
            $table->double('nhf_contribution_declared', 15, 2);
            $table->double('nhis_contribution_declared', 15, 2);
            $table->double('tax_free_pay', 15, 2);
            $table->double('chargeable_income', 15, 2);
            $table->double('tax_payable', 15, 2);
            $table->double('annual_tax', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_payers');
    }
}
