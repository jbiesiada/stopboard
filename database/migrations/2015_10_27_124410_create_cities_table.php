<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cities', function(Blueprint $table)
		{
			$table->increments('cityID');
			$table->text('name');
			$table->text('url');
		});
		DB::table('cities')->insert(
	        array(
	            'name' => 'Kraków',
	            'url' => 'http://rozklady.mpk.krakow.pl/linie.aspx'
	        )
	    );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cities');
	}

}
