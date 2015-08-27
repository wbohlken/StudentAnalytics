<?php namespace App\Http\Controllers;

use App\Model\CsvData;
use App\User;
use Request;
use Input;
use Redirect;
use Session;
use Validator;
use Auth;
use View;

class ProfileController extends Controller
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
        if (!Auth::user()->isStudent()) {
            return View::make('user.profile')->with('user', Auth::user());
        } else {
            return redirect('/');
        }
    }

    /**
     *
     * @return mixed
     */
    public function postUpdate()
    {
        $data = Input::all();
        $user = Auth::user();
        $validator = Validator::make($data, User::$updateRules, User::$errorMessages);
        if ($validator->fails()) {
            return Redirect::route('profile')->withErrors($validator->messages());
        } else {
            $user->fill($data);
            if ($user->save()) {
                Session::flash('success', 'je profiel is gewijzigd!');
            } else {
                Session::flash('error', 'je profiel kon niet opgeslagen worden');
            }
            return Redirect::route('profile');
        }
    }


}
