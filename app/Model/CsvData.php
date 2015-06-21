<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CsvData extends Model {
	protected $table = "csv_data";
        
        public static function getAllStudentnumbers() {
            $studentnumbers = \DB::table('csv_data')->lists('studnr_a');
            return $studentnumbers;
        }
}
