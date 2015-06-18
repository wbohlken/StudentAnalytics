<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoodleResultTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moodle_result', function ($table) {
			$table->increments("id");
			$table->tinyInteger("week_overview_id");
			$table->tinyInteger("assignment_week_nr");
			$table->string("type");
			$table->tinyInteger("grade")->default(0);
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
		Schema::drop('moodle_result');
	}

}
