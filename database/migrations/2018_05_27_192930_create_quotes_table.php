<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('job_card_no');
            $table->string('disctrict_id');
            $table->string('sub_disctrict_id');
            $table->string('prblem_type');
            $table->string('facility_name');
            $table->text('description');
            $table->integer('status');
            $table->dateTime('quotation_date');
            $table->dateTime('capturing_date');
            $table->dateTime('approved_date');
            $table->dateTime('reject_internal_date');
            $table->dateTime('reject_vetting_date');
            $table->dateTime('vetting_date');
            $table->dateTime('corrected_date');
            $table->dateTime('invoiced_date');
            $table->integer('contractor_id');
            $table->integer('inspector_id');
            $table->string('inspector_name');
            $table->integer('quotation_no');
            $table->integer('labour_amount');
            $table->double('travelling_time_amount',30);
            $table->double('travelling_cost',30);
            $table->text('desludgin_water_delive');
            $table->integer('accomodation');
            $table->integer('material_used_amount');
            $table->double('amount_excluding_vat',30);
            $table->double('amount_including_vat',30);
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
        Schema::dropIfExists('quotes');
    }
}
