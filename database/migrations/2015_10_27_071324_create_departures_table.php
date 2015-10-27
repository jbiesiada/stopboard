<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeparturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('departures', function(Blueprint $table)
		{
			$table->increments('departureID');
			$table->boolean('directory');
			$table->integer('hour');
			$table->integer('minute');
			$table->integer('dayType');
			$table->integer('lineID');
			$table->integer('stopID');
			$table->integer('cityID');			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('departures');
	}

}
