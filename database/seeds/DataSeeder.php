<?php

use\Illuminate\Database\Seeder;

use \App\Model\Student;
use \App\Model\Week;
use \App\Model\WeekOverview;
use \App\Model\LyndaData;
use \App\Model\MoodleResult;
use \App\Model\MyprogramminglabResult;
use \App\Model\MyprogramminglabTotal;
use \App\Model\Metadata;

class DataSeeder extends Seeder {
	/**
	 * Fill the database with sample data.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('student')->truncate();
		DB::table('week')->truncate();
		DB::table('week_overview')->truncate();
		DB::table('lynda_data')->truncate();
		DB::table('metadata')->truncate();

		$student1 = Student::create(['studnr_a' => '500669842', 'email' => 'wouter.bohlken@hva.nl', 'part_of_research' => TRUE,
				'block' => 1, 'cohort_block' => 1, 'cohort_year' => 1]);
		$week1 = Week::create(['week_nr' => 1, 'date' => date('Y-m-d')]);

		$metadata1 = Metadata::create(['week_id' => $week1->id, 'average_progress_group_1' => 10, 'average_progress_group_2' => 20, 'average_progress_total' => 15]);

		$weekOverview1 = WeekOverview::create(['student_id' => $student1->id, 'week_id' => $week1->id, 'view_key' => 'test123', 'progress' => 10]);

		$lyndaResult1 = LyndaData::create(['week_overview_id' => $weekOverview1->id, 'course_id' => 1, 'complete' => TRUE, 'hours_viewed' => 3]);
		$lyndaResult2 = LyndaData::create(['week_overview_id' => $weekOverview1->id, 'course_id' => 2, 'complete' => FALSE, 'hours_viewed' => 1]);

		$moodleResult1 = MoodleResult::create(['week_overview_id' => $weekOverview1->id, 'assignment_week_nr' => 1, 'type' => 'quiz', 'grade' => 4]);

		$myprogramminglabResult1 = MyprogramminglabResult::create(['week_overview_id' => $weekOverview1->id, 'assignment_week_nr' => 1, 'MMLAttempts' => 1.000000, 'MMLMastery' => 1.000000]);
		$myprogramminglabTotal1 = MyprogramminglabTotal::create(['week_overview_id' => $weekOverview1->id, 'correct_unassigned' => 53, 'incorrect_unassigned' => 23]);
	}
}