<?php namespace App\Http\Controllers;

use Input;
use Redirect;
use Session;
use Validator;

use App\Library\CsvImporters\GlobalImporter;

class HomeController extends Controller
{

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
		$this->middleware('guest');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

	public function upload()
	{
		$csvFile = Input::file('csv');

		$importer = new GlobalImporter($csvFile);
		$importer->import(TRUE);

		if ($importer->hasError()) {
			Session::flash('error', 'uploaded file is not valid');
			return Redirect::route('home');
		} else {
			Session::flash('success', 'Upload successful');
			return Redirect::route('home');
		}
	}
}
