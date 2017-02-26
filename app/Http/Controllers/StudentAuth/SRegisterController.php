<?php

namespace App\Http\Controllers\StudentAuth;

use App\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class SRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'school_id' => 'required|alpha_num|max:255',
            'name' => 'required|max:255',
            'class' => 'required|max:255',
            'email' => 'required|email|max:255|unique:students',
            'password' => 'required|min:6|confirmed',
        ], [
            'school_id.required' => '学号必须填写',
            'school_id.alpha_num' => '学号必须为字母或数字',
            'name.required' => '姓名必须填写',
            'class.required' => '班级必须填写',
            'email.required' => 'email必须填写',
            'email.unique' => 'email已被注册',
            'password.required' => '密码必须填写',
            'password.confirmed' => '两次密码输入不一致',
            'password.min' => '密码长度不能短于6位字符'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Student
     */
    protected function create(array $data)
    {
        return Student::create([
            'school_id' => $data['school_id'],
            'name' => $data['name'],
            'class' => $data['class'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('student.register');
    }

}
