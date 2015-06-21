<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMypgrogramminglabTotalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('myprogramminglab_total', function ($table) {
			$table->increments("id");
			$table->tinyInteger("week_overview_id");
			$table->tinyInteger("correct_unassigned")->default(0);
			$table->tinyInteger("incorrect_unassigned")->default(0);
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
		Schema::drop('myprogramminglab_total');
	}

}
