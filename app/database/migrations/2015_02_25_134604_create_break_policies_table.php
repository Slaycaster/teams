<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBreakPoliciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('break_policies', function(Blueprint $table) {
			$table->increments('id');
			$table->string('break_name');
			$table->text('description');
			$table->string('type');
			$table->time('active_after');
			$table->string('autodetect_breaksby');
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
		Schema::drop('break_policies');
	}

}
