<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRpixelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rpixels', function (Blueprint $table) {
            
            $table->id();
			$table->bigInteger('ID_users')->unsigned();
			$table->foreign('ID_users')->references('id')->on('users')->onDelete('cascade');
			$table->string('name');
			$table->text('code')->nullable();
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
        Schema::dropIfExists('rpixels');
    }
}
