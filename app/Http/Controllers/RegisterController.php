<?php

namespace App\Http\Controllers;

use App\Model\CsvData;
use App\Model\WeekOverview;
use App\User;
use App\Model\Week;
use Input;
use App\Model\Student;
use Redirect;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\DB;
use Auth;

class RegisterController extends Controller {
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
    public function __construct() {
        
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function getIndex() {
            if (Auth::user()->isAdmin()) {
                return view('register');
            } else {
                return redirect('/');
            }
    }

    public function register(CreateUserRequest $request)
    {
        $input = Input::all();
        $oUser = new User();
        $oUser->email = $input['email'];
        $oUser->password = Hash::make($input['password']);
        if (Input::has('admin')) {
        $oUser->admin = $input['admin'];
        }
        $oUser->name = $input['name'];

        if ($oUser->save()) {
            Mail::send('emails.adduser', ['name' => $oUser->name, 'password' => $input['password'], 'email' => $oUser->email, 'nameCurrent' => Auth::user()->name], function($oUser,$message)
            {
                $message->to($oUser->email, $oUser->name)->subject(Auth::user()->name . ' heeft een account voor je aangemaakt - Programming Dashboard');
            });
            Session::flash('success', 'De gebruiker ' . $oUser->name . ' is aangemaakt. De gebruiker heeft een e-mail ontvangen!');
        } else {
            Session::flash('error', 'De gebruiker kon niet aangemaakt worden');
        }
        return redirect('/register');


    }

}
