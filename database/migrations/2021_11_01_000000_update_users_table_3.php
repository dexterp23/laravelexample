<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('users', function (Blueprint $table) {
            
            $table->string('member_id');
			$table->index(['member_id']);
			$table->string('digi_id')->nullable();
			$table->string('digi_api_key')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
			
			$table->dropColumn('member_id');
			$table->dropColumn('digi_id');
			$table->dropColumn('digi_api_key');
			$table->dropIndex(['member_id']);
            
        });
    }
}
