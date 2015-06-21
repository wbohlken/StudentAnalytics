<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetadataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metadata', function ($table) {
			$table->increments("id");
			$table->tinyInteger("week_id");
			$table->tinyInteger("average_progress_group_1")->default(0);
			$table->tinyInteger("average_progress_group_2")->default(0);
			$table->tinyInteger("average_progress_total")->default(0);
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
		Schema::drop('metadata');
	}

}
