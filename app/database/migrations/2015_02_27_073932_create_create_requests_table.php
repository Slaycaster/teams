<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCreateRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('create_requests', function(Blueprint $table) {
			$table->increments('id');
			$table->string('status');
			$table->date('request_date');
			$table->date('start_date');
		
			$table->date('end_date');
		
			$table->string('message');
			$table->string('request_type');
			$table->integer('employee_id');
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
		Schema::drop('create_requests');
	}

}
