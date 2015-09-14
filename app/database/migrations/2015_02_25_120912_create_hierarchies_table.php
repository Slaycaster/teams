<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHierarchiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void 
	 */
	public function up()
	{
		Schema::create('hierarchies', function(Blueprint $table) {
			$table->increments('id');
			$table->string('hierarchy_name');
			$table->text('description');
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
		Schema::drop('hierarchies');
	}

}
