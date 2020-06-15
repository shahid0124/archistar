<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyticTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analytic_types', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', '91')
                ->comment('Analytics Name');

            $table->string('units', '91')
                ->comment('Units');

            $table->boolean('is_numeric')
                ->comment('Numeric value to decide analytics status');

            $table->integer('num_decimal_places')
                ->comment('Total Number of decimal Places');

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
        Schema::dropIfExists('analytic_types');
    }
}
