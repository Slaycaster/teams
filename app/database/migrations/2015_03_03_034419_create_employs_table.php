<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmploysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employs', function(Blueprint $table) {
			$table->increments('id');
			$table->string('employee_number');
			$table->string('lname');
			$table->string('fname');
			$table->string('midinit');
			$table->string('picture_path');
			$table->string('date_of_birth');
			$table->string('street');
			$table->string('barangay');
			$table->integer('city');
			$table->string('phone');
			$table->string('email');
			$table->date('hire_date');
			$table->string('status');
			$table->string('qr_code');
			$table->string('password');
			$table->integer('jobtitle_id');
			$table->integer('department_id');
			$table->integer('contract_id');
			$table->integer('level_id');
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
		Schema::drop('employs');
	}

}
