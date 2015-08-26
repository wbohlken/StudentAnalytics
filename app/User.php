<?php
namespace App;

use App\Model\WeekOverviewHistory;
use Auth;

use App\Model\WeekOverview;
use App\Model\Student;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	public $fillable = ['name', 'email', 'password', 'student_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * Registration rules
	 * @var array
	 */
	public static $registerRules = [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'student_nr' => 'required|numeric',
			'password' => 'required|confirmed|min:6',
	];

	/**
	 * Update rules
	 * @var array
	 */
	public static $updateRules = [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'student_nr' => 'required|numeric',
	];

	public function student() {
		return $this->belongsTo('App\Model\Student');
	}
	/**
	 * Custom error messages
	 * @var array
	 */
	public static $errorMessages = [
			'name.required' => 'Vul a.u.b. je naam in.',
			'name.max' => 'Uw naam is te lang.',
			'email.required' => 'Vul a.u.b. een e-mailadres in.',
			'email.email' => 'Vul a.u.b. een geldig e-mailadres in.',
			'email.max' => 'Uw e-mailadres is te lang.',
			'email.unique' => 'Dit e-mailadres is al in gebruik.',
			'student_nr.required' => 'Vul a.u.b. je studentnummer in.',
			'student_nr.numeric' => 'Vul a.u.b. een geldig studentnummer in.',
			'password.required' => 'Vul a.u.b. een wachtwoord in.',
			'password.min' => 'Uw wachtwoord moet minimaal 6 karakters bevatten.',
			'password.confirmed' => 'De wachtwoorden komen niet overeen.',
	];

	/**
	 * @return boolean
	 */
	public function isAdmin()
	{
		return $this->admin;
	}

	public function isStudent() {

		if ($this->student_id !== null) {
			return true;
		} else {
			return false;
		}
	}
	public static function createByStudentId($student)
	{
		$user = self::where('student_id', $student->id)->first();
		if (!$user) {
				$user = new User(['student_id' => $student->id, 'email' => $student->email]);
				$user->save();
		}
		//set participation in student to 1, so in database is clearly which student is participating
		$student = $user->student;
		$student->participation = 1;
		if ($student->save()) {
			return true;
		}
	}

	public static function loginByViewKey($viewKey)
	{
		$weekOverview = WeekOverview::getByViewKey($viewKey);
		if (!$weekOverview) {
			return FALSE;
		}
		$studnr_a = $weekOverview->student_id;
		$student = Student::where('studnr_a', $studnr_a)->first();

		$user = self::where('student_id', $student->id)->first();
		if (!$user) {
			$user = new User(['student_id' => $student->id, 'email' => $student->email]);
			$user->save();
		}
		//create new weekoverviewhistory
		$oWeekOverviewHistory = new WeekOverviewHistory();
		$oWeekOverviewHistory->user_id = $user->id;
		$oWeekOverviewHistory->week_overview_id = $weekOverview->id;
		$oWeekOverviewHistory->save();

		Auth::login($user);

		return $user;
	}

}
