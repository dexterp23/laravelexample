<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links_data', function (Blueprint $table) {
            
            $table->id();
			$table->bigInteger('ID_users')->unsigned();
			$table->foreign('ID_users')->references('id')->on('users')->onDelete('cascade');
			
			$table->bigInteger('links_id')->nullable();
			$table->string('ip')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('country')->nullable();
			$table->string('country_code')->nullable();
			$table->string('continent')->nullable();
			$table->string('continent_code')->nullable();
			$table->smallInteger('tier')->nullable();
			$table->string('browser_name')->nullable();
			$table->string('browser_version')->nullable();
			$table->string('os_platform')->nullable();
			$table->bigInteger('timestamp_created')->nullable();
			$table->smallInteger('click_type')->default('0');
			$table->float('lat', 20, 12)->default('0');
			$table->float('lng', 20, 12)->default('0');
			$table->string('timezone')->nullable();
			$table->string('currencyCode')->nullable();
			
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
        Schema::dropIfExists('links_data');
    }
}
