<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMypgrogramminglabResultTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('myprogramminglab_result', function ($table) {
			$table->increments("id");
			$table->tinyInteger("week_overview_id");
			$table->tinyInteger("assignment_week_nr");
			$table->double("MMLAttempts", 16, 8)->nullable();
			$table->double("MMLMastery", 16, 8)->nullable();
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
		Schema::drop('myprogramminglab_result');
	}

}
