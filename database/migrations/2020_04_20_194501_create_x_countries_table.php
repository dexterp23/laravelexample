<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_country', function (Blueprint $table) {
            
            $table->id();
			$table->string('country_code', 3);
			$table->string('name');
			$table->string('continent', 32);
			$table->float('offset', 3, 1);
			$table->string('TimeZoneId');
			$table->smallInteger('tier');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('x_country');
    }
}
