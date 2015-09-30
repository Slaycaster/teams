<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHolidayPoliciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('holiday_policies', function(Blueprint $table) {
			$table->increments('id');
			$table->string('holiday_name');
			$table->text('description');
			$table->string('default_schedule_status');
			$table->string('holiday_type');
			$table->time('holiday_time');
			$table->integer('day_of_month');
			$table->string('month');
			$table->string('year')
			$table->integer('branches_holiday_id');
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
		Schema::drop('holiday_policies');
	}

}
