<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLyndaDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lynda_data', function ($table) {
			$table->increments("id");
			$table->tinyInteger("week_overview_id");
			$table->string("course", 255);
			$table->boolean("complete")->default(FALSE);
			$table->tinyInteger("hours_viewed")->default(0);
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
		Schema::drop('lynda_data');
	}

}
