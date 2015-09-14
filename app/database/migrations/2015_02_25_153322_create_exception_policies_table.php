<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExceptionPoliciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exception_policies', function(Blueprint $table) {
			$table->increments('id');
			$table->string('is_active');
			$table->string('code');
			$table->string('exception_name');
			$table->string('severity');
			$table->time('grace');
			$table->time('watch_window');
			$table->string('email_notification');
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
		Schema::drop('exception_policies');
	}

}
