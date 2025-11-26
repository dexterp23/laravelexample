<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            
            $table->id();
			$table->bigInteger('ID_users')->unsigned();
			$table->foreign('ID_users')->references('id')->on('users')->onDelete('cascade');
			
			$table->bigInteger('vendor_id')->nullable();
			$table->string('name');
			$table->text('url');
			$table->smallInteger('status')->default('0');
			$table->bigInteger('domain_id')->nullable();
			$table->smallInteger('admin_domain')->default('0');
			$table->smallInteger('cloak_url')->default('0');
			$table->string('text_link');
			$table->bigInteger('group_id')->nullable();
			$table->bigInteger('rpixels_id')->nullable();
			$table->string('tracking_link');
			
			$table->smallInteger('rpixel_chk')->default('0');
			$table->smallInteger('dates_chk')->default('0');
			$table->smallInteger('pages_chk')->default('0');
			
			$table->date('date_start')->nullable();
			$table->time('time_start', $precision = 0)->nullable();
			$table->bigInteger('timestamp_start')->nullable();
			$table->date('date_end')->nullable();
			$table->time('time_end', $precision = 0)->nullable();
			$table->bigInteger('timestamp_end')->nullable();
			$table->smallInteger('endless_chk')->default('0');
			
			$table->bigInteger('page_id_pending')->nullable();
			$table->bigInteger('page_id_complete')->nullable();
			
			$table->integer('click_total')->default('0');
			$table->integer('click_unique')->default('0');
			
			$table->softDeletes();
			 
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
        Schema::dropIfExists('links');
    }
}
