<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePolicyGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('policy_groups', function(Blueprint $table) {
			$table->increments('id');
			$table->string('policygroup_name');
			$table->text('description');
			$table->integer('exception_id');
			$table->integer('overtime_id');
			$table->integer('premium_id');
			$table->integer('holiday_id');
			$table->integer('break_id');
			$table->integer('accrual_id');
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
		Schema::drop('policy_groups');
	}

}
