<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmpschedulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empschedules', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('employee_id');
			$table->integer('schedule_id');
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
		Schema::table('empschedules', function(Blueprint $table)
		{
			Schema::drop('empschedules');	
		});
	}

}
