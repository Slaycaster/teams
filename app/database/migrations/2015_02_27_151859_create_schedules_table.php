<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSchedulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedules', function(Blueprint $table) {
			$table->increments('id');
			$table->string('schedule_name');
			$table->text('description');
			$table->integer('break_duration');
			$table->time('sun_timein')->nullable();
			$table->time('sun_timeout')->nullable();
			$table->time('m_timein')->nullable();
			$table->time('m_timeout')->nullable();
			$table->time('t_timein')->nullable();
			$table->time('t_timeout')->nullable();
			$table->time('w_timein')->nullable();
			$table->time('w_timeout')->nullable();
			$table->time('th_timein')->nullable();
			$table->time('th_timeout')->nullable();
			$table->time('f_timein')->nullable();
			$table->time('f_timeout')->nullable();
			$table->time('sat_timein')->nullable();
			$table->time('sat_timeout')->nullable();
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
		Schema::drop('schedules');
	}

}
