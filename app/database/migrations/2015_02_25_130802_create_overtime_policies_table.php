<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOvertimePoliciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('overtime_policies', function(Blueprint $table) {
			$table->increments('id');
			$table->string('overtime_name');
			$table->text('description');
			$table->string('type');
			$table->integer('active_after');
			$table->integer('Allowed_number_of_hours');
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
		Schema::drop('overtime_policies');
	}

}
