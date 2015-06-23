<?php namespace App\Http\Controllers;

use App\Model\CsvData;
use App\Model\WeekOverview;
use App\User;
use Input;
use Redirect;
use Session;
use Validator;
use Auth;

class DashboardController extends Controller
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


	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		if (Auth::check()) {
			$studentnumbers = CsvData::getAllStudentnumbers();


			return view('dashboard', ['studentnumbers' => $studentnumbers]);
		} else {
			return redirect('/');
		}
	}

	public function getOverview($viewKey)
	{
		if (!User::loginByViewKey($viewKey)) {
			// TODO: proper error message.
			return "ongeldige view key";
		}
		$weekOverview = WeekOverview::getByViewKey($viewKey);
	}


	public function postStudentnumber()
	{
		if (Input::has('studentnumber')) {
			$studentnumber = Input::get('studentnumber');
			$student = CsvData::where('studnr_a', '=', $studentnumber)->first();
		}
	}
}
