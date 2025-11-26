<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksIpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links_ip', function (Blueprint $table) {
            
            $table->id();
			$table->bigInteger('ID_users')->unsigned();
			$table->foreign('ID_users')->references('id')->on('users')->onDelete('cascade');
			
			$table->bigInteger('links_id')->nullable();
			$table->string('ip')->nullable();
			
			$table->index(['links_id', 'ip']);
			
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
        Schema::dropIfExists('links_ip');
    }
}
