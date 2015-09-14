<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCreditPoliciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('credit_policies', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('description');
			$table->string('leave_type');
			$table->string('credit_reset');
			$table->date('preset_basis');
			$table->string('frequency');
			$table->integer('start_value');
			$table->integer('rate');
			$table->string('withdrawable');
			$table->integer('allowed_leaves');
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
		Schema::drop('credit_policies');
	}

}
