<?php
namespace App\Library\Importers;

use App\Model\LyndaData;
use App\Model\MoodleResult;
use App\Model\MyprogramminglabResult;
use App\Model\MyprogramminglabTotal;
use App\Model\Student;
use App\Model\Week;
use App\Model\WeekOverview;
use App\User;

class GlobalImporter
{
    private $data;
    private $week;

    public function __construct(array $data, $weekNr = 1)
    {

        $this->data = $data;
        $week = Week::where('week_nr', $weekNr)->first();
        if (!$week) {
            $week = Week::create(['week_nr' => $weekNr, 'date' => date('Y-m-d')]);
        }
        $this->week = $week;
    }

    public function  import()
    {
        foreach ($this->data as $row) {
            $this->importRow($row);
        }
    }


    private function importRow(array $row)
    {
        $studnr_a = $row['studnr_a'];

        // create student if not exists;
        $student = Student::createByStudnr($studnr_a);

        // create user if not exists
        User::createByStudentId($student->id);

        $weekOverview = new WeekOverview();
        $weekOverview->student_id = $student->id;
        $weekOverview->week_id = $this->week->id;
        $weekOverview->save();


        // Loop through all Moodle prac and quiz weeks
        for ($i = 1; $i <= 6; $i++) {
            foreach ($moodleTypes as $moodleType) {
                $grade = $row['w' . $i . '_' . $moodleType];

                $moodleResult = new MoodleResult();
                $moodleResult->week_overview_id = $weekOverview->id;
                $moodleResult->assignment_week_nr = $i;
                $moodleResult->type = $moodleType;
                $moodleResult->grade = $grade;
                $moodleResult->save();
            }
        }

        // Week 7 oefen toets
        $moodleResult = new MoodleResult();
        $moodleResult->week_overview_id = $weekOverview->id;
        $moodleResult->assignment_week_nr = 7;
        $moodleResult->type = 'oefen_toets';
        $moodleResult->grade = $row['w7_oefen_toets'];
        $moodleResult->save();

        $lyndaData = new LyndaData();
        $lyndaData->week_overview_id = $weekOverview->id;
        $lyndaData->course = $row['Course'];
        $lyndaData->complete = $row['complete'];
        $lyndaData->hours_viewed = $row['Hoursviewed'];
        $lyndaData->save();

        // Loop through all MPL weeks
        for ($i = 1; $i <= 8; $i++) {
            // Skip week 7
            if ($i == 7) {
                break;
            }
            $MMLAttempts = $row['W' . $i . '_MMLAttemps'];
            $MMLMastery = $row['W' . $i . '_MMLMastery'];

            $myprogrammingLabResult = new MyprogramminglabResult();
            $myprogrammingLabResult->assignment_week_nr = $i;
            $myprogrammingLabResult->week_overview_id = $weekOverview->id;
            $myprogrammingLabResult->MMLAttempts = $MMLAttempts;
            $myprogrammingLabResult->MMLMastery = $MMLMastery;
            $myprogrammingLabResult->save();
        }

        $myprogrammingLabTotal = new MyprogramminglabTotal();
        $myprogrammingLabTotal->week_overview_id = $weekOverview->id;
        $myprogrammingLabTotal->correct_unassigned = $row['CorrectUnassigned'];
        $myprogrammingLabTotal->incorrect_unassigned = $row['IncorrectUnassigned'];
        $myprogrammingLabTotal->save();
    }
}