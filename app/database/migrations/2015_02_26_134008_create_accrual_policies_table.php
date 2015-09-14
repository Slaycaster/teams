<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccrualPoliciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accrual_policies', function(Blueprint $table) {
			$table->increments('id');
			$table->string('accrual_name');
			$table->text('description');
			$table->string('frequency');
			$table->string('accrual_type');
			$table->integer('day_of_month');
			$table->string('month');
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
		Schema::drop('accrual_policies');
	}

}
