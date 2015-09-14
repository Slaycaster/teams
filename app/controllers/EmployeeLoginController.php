<?php

class EmployeeLoginController extends BaseController
{
	public function showLogin()
	{
		return View::make('employeelogin');
	}

	public function doLogin()
	{
		$rules = array(
			'username'   => 'required', 
			'password'=> 'required|alphaNum|min:4'

			);


		$validator = Validator::make(Input::all(), $rules);

		if($validator -> fails()){

			return Redirect::to('login/employee')
			->withErrors($validator)
			->withInput(Input::except('password')); 
		}
		else
		{
			$user = Input::get('username');
			$pass = Input::get('password');
			$credentials = DB::table('employs')->where('employee_number', '=', $user)->where('password', '=', $pass)->get();
			
			if (count($credentials) > 0) {
				foreach ($credentials as $key => $value) {
					$employeename = $value->fname. ' ' .$value->lname;
					$username = $value->email;
					$employeeid = $value->id;
					$level = $value->level_id;
				}
				Session::put('empid', $employeeid);
				Session::put('empname', $employeename);
				Session::put('empemail', $username);
				Session::put('emplevel', $level);
				return Redirect::to('employee/dashboard');
			}
			else
			{
				Session::flash('message', 'Sorry! Incorrect username/password. Please try again.');
				return Redirect::to('login/employee');
			}
		}
	}//doLogin

	public function doLogout()
	{
		Session::flush();
		Session::flash('message2', 'Successfully logged out. Have a good day!');
				return Redirect::to('login/employee');
	}

	public function showDashboard()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			return View::make('employs.dashboard')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
		
	}

	

	public function showTimeSheet()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			return View::make('timesheet')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	public function showTimeSheetTable()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			return View::make('timesheet.table')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	public function showAccumulatedHours()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			return View::make('accumulated_hours')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}
	public function showExceptions()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			return View::make('exceptions')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}
	public function showAccruals()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			return View::make('accruals')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

    public function showDTR()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$employees = DB::table('employs')->where('level_id', '=', '0')->get();
			$requests = DB::table('create_requests')->get();
		return View::make('dailytimerecord')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('employees', $employees)
				->with('requests', $requests);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}	
	public function showRequestsAuthorization()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$employees = DB::table('employs')->where('level_id', '=', '0')->get();
			$requests = DB::table('create_requests')->get();
			return View::make('request_authorization')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('employees', $employees)
				->with('requests', $requests);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	public function showChangePassword()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$employees = DB::table('employs')->where('level_id', '=', '0')->get();
			$requests = DB::table('create_requests')->get();
			return View::make('change_password')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('employees', $employees)
				->with('requests', $requests);
				
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}


public function showDownload()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {

			$downloads = DB::table('downloads')->get();
			return View::make('downloads')
				->with('downloads', $downloads);
				
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	public function showLeaveCredit()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$employees = DB::table('employs')->get();
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			
		
			
			   // MySQL datetime format
			
			foreach ($employees as $employee) {
			
			if ($employee->id == $id)
			{
			
			$hdate = $employee->hire_date;
			$ts1=strtotime($hdate);
			$ts2=strtotime($now);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$day1 = date('d', $ts1); /* I'VE ADDED THE DAY VARIABLE OF DATE1 AND DATE2 */
			$day2 = date('d', $ts2);

			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

			/* IF THE DAY2 IS LESS THAN DAY1, IT WILL LESSEN THE $diff VALUE BY ONE */

			if($day2<$day1){ $diff=$diff-1; }

		
				if($diff >= 12)
					{
						if ($diff > 11){
							$totyear= round($totyear = ($diff / 12), 0);
							$totmonth = round(($diff % 12), 0);

							$sick_leave = (($totyear *15) + $totmonth * 1.25);

							$vacation_leave = (($totyear *15) + $totmonth * 1.25);
						
							if($vacation_leave > 9)
							{
								
								$force_counter = 5 * $totyear;
								$force_leave = 5;
								$vacation_leave = (($totyear *15) + $totmonth * 1.25) - $force_counter;
							}
							else {
								$force_leave = 0;
							}
						}
						if($diff < 11)
						{
							$sick_leave = $diff * 1.25;
							$vacation_leave = $diff * 1.25; 
								if($vacation_leave > 9)
							{
								
								$force_leave = 5;
								$vacation_leave = ($diff * 1.25) - $force_leave;
							}
							else {
								$force_leave = 0;
							}
						}

						
						}
					
					else {
						$sick_leave = 0;
						$vacation_leave = 0;
						$force_leave = 0;
						}
					}

			}
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			return View::make('leave_credits')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('force_leave', $force_leave)
				->with('sick_leave', $sick_leave)
				->with('vacation_leave', $vacation_leave);
			
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

		
    public function changePassword() 
	{
	    $validator = Validator::make(Input::all(),
			array(
				'new_password' 		=> 'required',
				'old_password'	=> 'required|min:6',
				'password_again'=> 'required|same:new_password'
			)
		);

		if($validator->fails()) 
		{
			return Redirect::to('employee/change_password')
				->withErrors($validator);

		} else {
			
			$id = Session::get('empid', 'default');

			$old_password = DB::table('employs')->select('password as old_password')->where('id', '=', $id)->get();		
			
			foreach ($old_password as $value) {
				if (Input::get('old_password') == $value->old_password) 
				{
					DB::table('employs')->where('id', '=', $id)->update(array('password' => Input::get('new_password')));
					Session::flash('changepw_success', 'Change password success!');
					return Redirect::to('employee/change_password');	
				}
				else
				{
					Session::flash('changepw_error', 'Invalid old password!');
					return Redirect::to('employee/change_password');
				}

			}
			

		}
	}
}
?>