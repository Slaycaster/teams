<?php

class AttendanceLoginController extends BaseController
{
	public function showLogin()
	{
		return View::make('attendancelogin');
	}

	public function doLogin()
	{
		$rules = array(
			'username'   => 'required', 
			'password'=> 'required|alphaNum|min:4'

			);


		$validator = Validator::make(Input::all(), $rules);

		if($validator -> fails()){

			return Redirect::to('employee/attendance')
			->withErrors($validator)
			->withInput(Input::except('password')); 
		}
		else
		{
			$user = Input::get('username');
			$pass = Input::get('password');
			$credentials = DB::table('employees')->where('email', '=', $user)->where('password', '=', $pass)->get();
			if (count($credentials) > 0) {
				foreach ($credentials as $key => $value) {
					$employeename = $value->firstname. ' ' .$value->lastname;
					$username = $value->email;
					$employeeid = $value->id;
				}
				Session::put('empid', $employeeid);
				Session::put('empname', $employeename);
				Session::put('empemail', $username);
				return Redirect::to('employee/dashboard');
			}
			else
			{
				Session::flash('message', 'Sorry! Incorrect username/password. Please try again.');
				return Redirect::to('employee/attendance');
			}
		}
	}//doLogin



   
	public function doLogout()
	{
		Session::flush();
		Session::flash('message2', 'Successfully logged out. Have a good day!');
				return Redirect::to('employee/attendance');
	}

	public function showDashboard()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			return View::make('employees.dashboard')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('employee/attendance');
		}
		
	}
}
?>