<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectorsManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspectors_management', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('district_id');
            $table->integer('sub_district_id');
            $table->integer('inspector_id');
            $table->string('disctrict_name');
            $table->string('sub_disctrict_name');
            $table->string('inspector_name');
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
        Schema::dropIfExists('inspectors_management');
    }
}
