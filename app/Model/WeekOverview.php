<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WeekOverview extends Model {

    protected $table = "week_overview";

    public function moodleResult() {
        return $this->hasMany('App\Model\MoodleResult');
    }

    public function lyndaData() {
        return $this->hasMany('App\Model\LyndaData');
    }

    public function myprogramminglabResult() {
        return $this->hasMany('App\Model\MyprogramminglabResult');
    }

    public function myprogramminglabTotal() {
        return $this->hasOne('App\Model\MyprogramminglabTotal');
    }

    public function student() {
        return $this->belongsTo('App\Model\Student', 'studnr_a');
    }

    public function week() {
        return $this->belongsTo('App\Model\Week');
    }

    public function weekoverviewhistory() {
        return $this->hasMany('App\Model\WeekOverviewHistory');
    }


//    public static function boot() {
//        parent::boot();
//
//        WeekOverview::creating(function($weekOverview) {
//            $weekOverview->generateViewKey();
//        });
//    }



    public static function getByViewKey($viewKey) {
        return self::with('moodleResult', 'lyndaData', 'myprogramminglabResult', 'myprogramminglabTotal')
                        ->where('view_key', $viewKey)->first();
    }

    public function generateViewKey() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        
        $viewKey = '';
        for ($i = 0; $i < 64; $i++) {
            $viewKey .= $characters[rand(0, $charactersLength - 1)];
        }
        $this->view_key = $viewKey;
        $this->save();
    }

    public function getMainResults() {
        $MPLResult = $this->getMPLResult();
        $lyndaResult = $this->getLyndaResult();
        $moodleResult = $this->getMoodleResult();
        $totalResult = $this->getTotalResult();

        return array('MPLresult' => $MPLResult, 'LyndaResult' => $lyndaResult, 'MoodleResult' => $moodleResult, 'TotalResult' => $totalResult);
    }

    private function getMPLResult() {
            $mpldata = $this->myprogramminglabResult()->get();
            if (!$mpldata->isEmpty()) {
            $mplattempts = $mpldata[0]['MMLAttempts'];
            $mplmastery = $mpldata[0]['MMLMastery'];
            } else {
                $mplattempts = 0;
                $mplmastery = 0;
            }
            
            return array('MMLMastery' => $mplmastery, 'MMLAttempts' => number_format($mplattempts, 2, '.', ','));
            
    }
    
    private function getLyndaResult() {
        // Get total grade for the type 'Quiz'
        $lyndadata = LyndaData::where('week_overview_id', $this->id)->first();
        $complete = $lyndadata->complete;
        $hours_viewed = $lyndadata->hours_viewed;
        
        return array('complete' => $complete, 'hoursviewed' => $hours_viewed);
    }

    private function getMoodleResult() {

         // Get total grade for the type 'Quiz'
        $quizresult = MoodleResult::where('type', 'quiz')->where('week_overview_id', $this->id)->first();
        $gradeQuiz = $quizresult->grade;

        // Get total grade for the type 'Prac'
        $pracresult = MoodleResult::where('type', 'prac')->where('week_overview_id', $this->id )->first();
        $gradePrac = $pracresult->grade;
        
        return array('pracGrade' => $gradePrac, 'quizGrade' => $gradeQuiz);
    }
    
    
    private function getTotalResult() {
        $aMoodleResult = $this->getMoodleResult();
        $moodleResult = $this->getTotalMoodleResult($aMoodleResult['pracGrade'], $aMoodleResult['quizGrade']);
        $MPLResults = $this->getMPLResult();
        
         $total =  $moodleResult + $MPLResults['MMLMastery'];
        // endtotal max 200 because of 2 x 100.
        $endtotal = ($total / 200) * 100;
         return $endtotal;
    }
    
    
    public function getAverageResults() {
        $averageMoodleResult = $this->getAverageMoodleResult(); 
        $averageLyndaResult = $this->getAverageLyndaResult();
        $averageMPLResult = $this->getAverageMPLResult();
        $averageTotal = $this->getAverageTotalResult();
        $averageGrade = $this->getAverageGrade();
        
        return array('MPLresult' => $averageMPLResult, 'LyndaResult' => $averageLyndaResult, 'MoodleResult' => $averageMoodleResult, 'TotalResult' => $averageTotal, 'AverageGrade' => $averageGrade);

    }

    private function getAverageGrade() {
        $week = Week::where('id', $this->week_id)->first();

        $totalStudentsGrades = WeekOverview::where('week_id', $week->id)->sum('estimated_grade');
        $totalStudents = WeekOverview::where('week_id', $week->id)->count();
        $averageGrade = $totalStudentsGrades / $totalStudents;
        return number_format($averageGrade,1);
    }

    private function getAverageMoodleResult() {
        $week = Week::where('id', $this->week_id)->first();
        
        // Get total grade for the type 'Quiz'
        $quizTotalGrade = MoodleResult::where('type', 'quiz')->where('week_overview_id', $this->id )->sum('grade');
        
        // Get total grade for the type 'Prac'
        $pracTotalGrade = MoodleResult::where('type', 'prac')->where('week_overview_id', $this->id )->sum('grade');
        
        // Get total students for both types
        $totalStudentsQuiz = count(MoodleResult::where('type', 'quiz')->where('week_overview_id', $this->id)->get());
        $totalStudentsPrac = count(MoodleResult::where('type', 'prac')->where('week_overview_id', $this->id)->get());
       
        // Calculate the average for both types
        $averageQuiz = ($quizTotalGrade / $totalStudentsQuiz);
        $averagePrac = ($pracTotalGrade / $totalStudentsPrac);
        
        return array('averageQuiz' => number_format($averageQuiz, 2, '.', ','), 'averagePrac' => number_format($averagePrac, 2, '.', ','));
    }
    
    private function getAverageLyndaResult() {
        //Get all overviews for this week
        $ooWeekOverviewsByWeek = WeekOverview::where('week_id', $this->week_id);
        
        //Lists the id for all weekoverviews of this week
        $oWeekOverviewIds = $ooWeekOverviewsByWeek->lists('id');
        
        //get the total completed data for Lynda
        $lyndaTotalComplete = LyndaData::whereIn('week_overview_id', $oWeekOverviewIds)->sum('complete');
        
        //get the total hours viewed data for lynda
        $lyndaTotalHoursViewed = LyndaData::whereIn('week_overview_id', $oWeekOverviewIds)->sum('hours_viewed');
        
        //get the total students for calculating
        $lyndaTotalStudents = count(LyndaData::whereIn('week_overview_id', $oWeekOverviewIds)->get());
        
        //Calculate the average of lynda completion and hours viewed
        $averageHoursViewedLynda = ($lyndaTotalHoursViewed / $lyndaTotalHoursViewed);
        $averageCompletionLynda = ($lyndaTotalComplete / $lyndaTotalStudents);
        
        return array('complete' => $averageCompletionLynda, 'hoursviewed' => $averageHoursViewedLynda);
       
    }
    
    private function getAverageMPLResult() {
        $week = Week::where('id', $this->week_id)->first();
        
        //Count total Mastery and Attempts overall this week.
        $MPLTotalMastery = MyprogramminglabResult::where('week_overview_id', $this->id )->sum('MMLMastery');
        $MPLTotalAttempts = MyprogramminglabResult::where('week_overview_id', $this->id)->sum('MMLAttempts');
        
        // Count total students for this week
        $MPLTotalStudents = count(MyprogramminglabResult::where('week_overview_id', $this->id)->get());
        
        //Calculate the averages
        $averageMPLMastery = ($MPLTotalMastery / $MPLTotalStudents);
        $averageMPLAttempts = ($MPLTotalAttempts / $MPLTotalStudents);
        
        return array('averageMastery' => $averageMPLMastery, 'averageAttempts' => number_format($averageMPLAttempts, 2, '.', ','));
        
    }
    
    
    private function getAverageTotalResult() {
        $aAverageMoodleResult = $this->getAverageMoodleResult();
        $averageMoodleResult = $this->getTotalMoodleResult($aAverageMoodleResult['averagePrac'], $aAverageMoodleResult['averageQuiz']);
        $averageMPLResults = $this->getAverageMPLResult();
        
        $total =  $averageMoodleResult + $averageMPLResults['averageMastery'];
        // endtotal max 200 because of 2 x 100.
        $endtotal = ($total / 200) * 100;
         return $endtotal;
    }
    
    private function getTotalMoodleResult($prac, $quiz) {
        //Caclulation of percentage of Moodle
        // case 1: Quiz 1 + prac 1 = 100%
        // case 2: Quiz 1 + prac 0 = 20%
        // case 3: Quiz 0 + prac 1 = 80%
        // case 4: Quiz 0 + prac 0 = 0%
        if ($quiz !== 0 && $prac !== 0) {
            return 100;
        } elseif ($quiz == 0 && $prac !== 0) {
            return 80;
        } elseif ($quiz !== 0 && $prac == 0) {
            return 20;
        } elseif ($quiz == 0 && $prac == 0) {
            return 0;
        }
    }
    

}

