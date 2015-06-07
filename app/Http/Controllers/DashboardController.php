<?php namespace App\Http\Controllers;

use App\Model\CsvData;
use Input;
use Redirect;
use Session;
use Validator;

class DashboardController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
            
		
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{

		return view('dashboard');
	}

	public function upload()
	{
		$csvFile = Input::file('csv');
		$file = array('csv' => $csvFile);
		$rules = array('csv' => 'required',);

		$validator = Validator::make($file, $rules);
		if ($validator->fails()) {
			return Redirect::to('post-csv')->withInput()->withErrors($validator);
		}
		else {
			if ($csvFile->isValid()) {
				$destinationPath = storage_path() . '/files';
				$fileName = $csvFile->getClientOriginalName();
				$csvFile->move($destinationPath, $fileName);
				CsvData::import($fileName, TRUE);

				Session::flash('success', 'Upload successful');
				return Redirect::route('home');
			}
			else {
				Session::flash('error', 'uploaded file is not valid');
				return Redirect::route('home');
			}
		}
	}
}
