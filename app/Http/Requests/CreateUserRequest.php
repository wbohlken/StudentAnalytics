<?php namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Response;

class CreateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8'
        ];
    }

    public function authorize()
    {
        if (!Auth::check()) {
            return false;
        }
        if (Auth::user()->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }
}
