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
        return $this->belongsTo('App\Model\Student');
    }

    public function week() {
        return $this->belongsTo('App\Model\Week');
    }

    public static function boot() {
        parent::boot();

        WeekOverview::creating(function($weekOverview) {
            $weekOverview->generateViewKey();
        });
    }

    public static function getByViewKey($viewKey) {
        return self::with('moodleResult', 'lyndaData', 'myprogramminglabResult', 'myprogramminglabTotal')
                        ->where('view_key', $viewKey)->first();
    }

    private function generateViewKey() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $viewKey = '';
        for ($i = 0; $i < 64; $i++) {
            $viewKey .= $characters[rand(0, $charactersLength - 1)];
        }
        $this->view_key = $viewKey;
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
            
            
            return array('MMLMastery' => $mplmastery, 'MMLAttempts' => $mplattempts);
            
    }

    private function getLyndaResult() {
        $lyndadata = $this->lyndaData()->get();
        
        if (!$lyndadata->isEmpty()) {
            return $lyndadata[0]['complete'];
        } else {
            return 0;
        }
    }

    private function getMoodleResult() {
        $moodledata = $this->moodleResult()->get();
        
        if (!$moodledata->isEmpty()) {
            return $moodledata[0]['grade'];
        } else {
            return 0;
        }
    }
    
    public function getTotalResult() {

        $lyndaResult = $this->getLyndaResult();
        $moodleResult = $this->getMoodleResult();
        $MPLResults = $this->getMPLResult();
        $total = $lyndaResult + $moodleResult + $MPLResults['MMLMastery'] + $MPLResults['MMLAttempts'];
        // endtotal max 400 because of 4 x 100.
        $endtotal = ($total / 400) * 100;
         return $endtotal;
    }
    
    

}
