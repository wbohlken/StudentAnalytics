<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('student', function ($table) {
			$table->increments("id");
			$table->integer("studnr_a")->nullable();
			$table->string("email");
			$table->boolean("part_of_research")->default(0);
			$table->tinyInteger("block");
			$table->integer("cohort_block");
			$table->integer("cohort_year");
			$table->string("preschool_type")->nullable();
			$table->string("profile")->nullable();
			$table->string("preschool_profile")->nullable();
			$table->string("class")->nullable();
			$table->tinyInteger("final_grade")->nullable();
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
		Schema::drop('student');
	}

}
