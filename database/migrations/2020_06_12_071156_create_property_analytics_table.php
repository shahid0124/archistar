<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_analytics', function (Blueprint $table) {
            $table->unsignedInteger('property_id')
                ->comment('Foreign Key of Property Table');

            $table->unsignedInteger('analytic_type_id')
                ->comment('Foreign Key of analytics type');

            $table->text('value')
                ->nullable(true);

            $table->timestamps();

            $table->primary(['property_id', 'analytic_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_analytics');
    }
}
