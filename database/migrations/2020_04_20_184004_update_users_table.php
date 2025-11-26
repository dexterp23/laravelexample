<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->smallInteger('publish')->default('1');
           	$table->enum('role', ['user','admin'])->default('user');
            $table->bigInteger('id_user_settings');
			$table->string('timeZone')->default('Europe/Brussels');
            
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
            
            $table->dropColumn('publish');
            $table->dropColumn('role');
            $table->dropColumn('id_user_settings');
			$table->dropColumn('timeZone');
            
        });
    }
}
