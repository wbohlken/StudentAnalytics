<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Student extends Model {
	protected $table = "student";

	public static function import()
	{
		self::truncate();
		$fileName = storage_path('files') . '/sample_data.csv';

		$file = file($fileName);
		$csvColumns = $file[0];
		$columns = str_getcsv($csvColumns, ';');

		foreach ($file as $key => $row) {
			if ($key > 0) {
				$student = new self();
				$csvRow = str_getcsv($row, ';');
				foreach ($csvRow as $columnKey => $value) {
					$student->{$columns[$columnKey]} = str_replace(',', '.', $value);
				}
				$student->save();
			}
		}
	}
}