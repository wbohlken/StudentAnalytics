<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeekOverviewTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('week_overview', function ($table) {
			$table->increments("id");
			$table->tinyInteger("week_id");
			$table->integer("student_id");
			$table->string("view_key")->nullable();
			$table->tinyInteger("progress")->default(0);
			$table->date("opened_on")->nullable();
			$table->tinyInteger("estimated_grade")->nullable();
			$table->tinyInteger("estimated_risk")->nullable();
			$table->tinyInteger("estimated_risk_factor")->nullable();
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
		Schema::drop('week_overview');
	}

}
