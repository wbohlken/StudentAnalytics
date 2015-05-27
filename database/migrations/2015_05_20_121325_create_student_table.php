<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTable extends Migration
{

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
			$table->integer("result")->nullable();
			$table->integer("cohort")->nullable();
			$table->integer("cohort_blok")->nullable();
			$table->integer("cohort_jaar")->nullable();
			$table->integer("vooropl_type")->nullable();
			$table->integer("profiel")->nullable();
			$table->integer("vooropl_profiel")->nullable();
			$table->double("w1_prac", 5, 2)->nullable();
			$table->double("w2_prac", 5, 2)->nullable();
			$table->double("w3_prac", 5, 2)->nullable();
			$table->double("w4_prac", 5, 2)->nullable();
			$table->double("w5_prac", 5, 2)->nullable();
			$table->double("w6_prac", 5, 2)->nullable();
			$table->double("w1_quiz", 5, 2)->nullable();
			$table->double("w2_quiz", 5, 2)->nullable();
			$table->double("w3_quiz", 5, 2)->nullable();
			$table->double("w4_quiz", 5, 2)->nullable();
			$table->double("w5_quiz", 5, 2)->nullable();
			$table->double("w6_quiz", 5, 2)->nullable();
			$table->double("w7_oefen_toets", 5, 2)->nullable();
			$table->double("Category_total", 5, 2)->nullable();
			$table->integer("CorrectUnassigned")->nullable();
			$table->integer("IncorrectUnassigned")->nullable();
			$table->double("W1_MMLAttemps", 7, 7)->nullable();
			$table->double("W1_MMLMastery", 7, 7)->nullable();
			$table->double("W2_MMLAattemps", 7, 7)->nullable();
			$table->double("W2_MMLMastery", 7, 7)->nullable();
			$table->double("W3_MMLAttemps", 7, 7)->nullable();
			$table->double("W3_MMLMastery", 7, 7)->nullable();
			$table->double("W4_MMLAttemps", 7, 7)->nullable();
			$table->double("W4_MMLMastery", 7, 7)->nullable();
			$table->double("W5_MMLAttemps", 7, 7)->nullable();
			$table->double("W5_MMLMastery", 7, 7)->nullable();
			$table->double("W6_MMLAttemps", 7, 7)->nullable();
			$table->double("W6_MMLMastery", 7, 7)->nullable();
			$table->double("W8_MMLAttemps", 7, 7)->nullable();
			$table->double("W8_MMLMastery", 7, 7)->nullable();
			$table->string("Course", 50)->nullable();
			$table->double("complete", 5, 2)->nullable();
			$table->double("Hoursviewed", 5, 2)->nullable();
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
