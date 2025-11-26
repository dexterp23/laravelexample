<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            
            $table->id();
			$table->bigInteger('ID_users')->unsigned();
			$table->foreign('ID_users')->references('id')->on('users')->onDelete('cascade');
			$table->string('name');
			$table->text('url');
			$table->smallInteger('panding_def')->default('0');
			$table->smallInteger('complete_def')->default('0');
			$table->smallInteger('404_def')->default('0');
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
        Schema::dropIfExists('pages');
    }
}
