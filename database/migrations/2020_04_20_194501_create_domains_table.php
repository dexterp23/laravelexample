<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            
            $table->id();
			$table->bigInteger('ID_users')->unsigned();
			$table->foreign('ID_users')->references('id')->on('users')->onDelete('cascade');
			$table->string('name');
			$table->string('slug');
			$table->text('url');
			$table->string('cname');
			$table->text('default_url')->nullable();
			$table->text('pixel_code')->nullable();
			$table->smallInteger('is_forward')->default('0');
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
        Schema::dropIfExists('domains');
    }
}
