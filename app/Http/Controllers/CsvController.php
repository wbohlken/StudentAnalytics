<?php

namespace App\Http\Controllers;

use App\Library\CsvImporters\GlobalImporter;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Console\Commands\ImportStudentsCommand;
use App\Model\CsvData;
use App\Model\Student;

/**
 * Class CsvController
 * @package App\Http\Controllers
 */
class CsvController extends Controller {

	/**
	 * @return \Illuminate\View\View
	 */
	public function getUpload()
	{
		return view('upload');
	}

	/**
	 * @return mixed
	 */
	public function postUpload()
	{
		$csvFile = Input::file('file');
		$importer = new GlobalImporter($csvFile);
		$importer->import();
		if ($importer->hasError()) {
			Session::flash('error', 'uploaded file is not valid');
			return Redirect::route('upload-csv');
		} else {
                        
			Session::flash('success', 'Upload successful');
			return Redirect::route('upload-csv');
		}
                
                
	}
}