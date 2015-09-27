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
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$count = DB::table('create_requests')->join('hierarchy_subordinates', 'create_requests.employee_id', '=', 'hierarchy_subordinates.employee_id')
			->join('hierarchies', 'hierarchy_subordinates.hierarchy_id', '=', 'hierarchies.id')
			->where('supervisor_id', '=', $id)
			->where('status','=','pending')->count();
			return View::make('employs.dashboard')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('supervisor',$supervisor)
				->with('count',$count);
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

	public function showLeaveHistory()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$create_requests = DB::table('create_requests')->where('employee_id', '=', $id)->orderby('id', 'desc')->get();
			$request_types = DB::table('request_types')->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			return View::make('leavehistory')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('create_requests', $create_requests)
				->with('supervisor', $supervisor)
				->with('request_types', $request_types);
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
			$acchrs = 0;
			$total = 0;
			$overtime = 0;
			$datenow = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$dateto = "";
			$now = $datenow->format('Y-m-d');
			$timenow = $datenow->format('g:i a');
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$ifot = DB::table('overtime_subordinates')
			->select('overtime_id')
			->where('employee_id','=',$id)
			->lists('overtime_id');
			if($ifot != null)
			{
				$allowedothr = DB::table('overtime_policies')
				->where('id','=',$ifot)
				->get();
			}
			$ifsched = DB::table('empschedules')
			->select('schedule_id')
			->where('employee_id','=',$id)
			->lists('schedule_id');
			if($ifsched != null)
			{
				$schedto = DB::table('schedules')
				->select('m_timeout')
				->where('id','=',$ifsched)
				->get();
			}
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$punchin = DB::table('punchstatus')
			->select('time_in_punch_id')
			->where('employee_id','=',$id)
			->where('date','=',$now)
			->lists('time_in_punch_id');
			$punchout =DB::table('punchstatus')
			->select('time_out_punch_id')
			->where('employee_id','=',$id)
			->where('date','=',$now)
			->lists('time_out_punch_id');

			if($punchin != null && $punchout != null)
			{
				$timein = DB::table('punches')
				->where('id','=',$punchin)
				->get();

				$timeout = DB::table('punches')
				->where('id','=',$punchout)
				->get();

				foreach($timein as $time_in)
				{
					foreach($timeout as $time_out)
					{
						foreach($schedto as $sched)
						{
							if($time_out->time > $sched->m_timeout)
							{
							if($ifot != null)
							{
								//if(count($allowedothr))
								
									foreach($allowedothr as $hr)
									{
										foreach($schedto as $schedout)
										{
											$span = ($schedout->m_timeout + $hr->Allowed_number_of_hours) + $hr->active_after;
											if($time_out->time > $span)
											{
												$overtime = ($span - $schedout->m_timeout) - $hr->active_after;
											}
											else
											{	
												$overtime = ($time_out->time - $schedout->m_timeout) - $hr->active_after;
											}
											$acchrs = $schedout->m_timeout - $time_in->time;
											if($acchrs < 0 )
											{
												$acchrs = $acchrs + 12;
											}
											$total = $total + $acchrs + $overtime;
										} 
									}
									
								
								
							}
							else
							{
								foreach($schedto as $schedout)
								{
									$acchrs = $schedout->m_timeout - $time_in->time;
									if($acchrs < 0 )
									{
										$acchrs = $acchrs + 12;
							
									}
									$total = $total + $acchrs + $overtime;
								}

							}
							
						}
						else
						{
							$acchrs = $time_out->time - $time_in->time;
							if($acchrs < 0 )
							{
								$acchrs = $acchrs + 12;
							
							}
							$total = $total + $acchrs + $overtime;
						}
					}

					}
				}
			}
			

			return View::make('accumulated_hours')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('total',$total)
				->with('supervisor',$supervisor)
				->with('punchin',$punchin)
				->with('punchout',$punchout)
				->with('acchrs',$acchrs)
				->with('level', $level)
				->with('now',$now)
				->with('overtime',$overtime)
				->with('timenow',$timenow)
				->with('dateto',$dateto);
			}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	public function postshowAccumulatedHours()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$acchrs = 0;
			$total = 0;
			$overtime = 0;
			$hrs = 0;
			$othrs = 0;
			$datefrom = Input::get('datefrom');
			$dateto = Input::get('dateto');
			$now = Input::get('datefrom');
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$ifot = DB::table('overtime_subordinates')
			->select('overtime_id')
			->where('employee_id','=',$id)
			->lists('overtime_id');
			if($ifot != null)
			{
				$allowedothr = DB::table('overtime_policies')
				->where('id','=',$ifot)
				->get();
			}
			$ifsched = DB::table('empschedules')
			->select('schedule_id')
			->where('employee_id','=',$id)
			->lists('schedule_id');
			if($ifsched != null)
			{
				$schedto = DB::table('schedules')
				->select('m_timeout')
				->where('id','=',$ifsched)
				->get();
			}
			$punchin = DB::table('punchstatus')
			->select('time_in_punch_id')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('employee_id','=',$id)
			//->where('date','=',$datefrom)
			->lists('time_in_punch_id');
			$punchout =DB::table('punchstatus')
			->select('time_out_punch_id')
			->whereBetween('punchstatus.date', array($datefrom, $dateto))
			->where('employee_id','=',$id)
			->lists('time_out_punch_id');
			
			if($punchin != null && $punchout != null)
			{
				$timein = DB::table('punches')
				->whereIn('id',$punchin)
				->get();
				
				$timeout = DB::table('punches')
				->whereIn('id',$punchout)
				->get();
				
				foreach($timeout as $time_out)
				{
					foreach($timein as $time_in)
					{
						foreach($schedto as $sched)
						{
							if($time_out->time > $sched->m_timeout)
							{
							if($ifot != null)
							{
								foreach($allowedothr as $hr)
								{
									foreach($schedto as $schedout)
									{
										$span = ($schedout->m_timeout + $hr->Allowed_number_of_hours) + $hr->active_after;
										
										if($time_out->time > $span)
										{
											$overtime = ($span - $schedout->m_timeout) - $hr->active_after;


										}
										else
										{	
											$overtime = ($time_out->time - $schedout->m_timeout) - $hr->active_after;

										}

										$acchrs = $schedout->m_timeout - $time_in->time;
										//$acchrs = $time_out->time - $time_in->time;
										if($acchrs < 0 )
										{
											$acchrs = $acchrs + 12;
										}
									}
								}
							}
							else
							{
								foreach($schedto as $schedout)
								{
									$acchrs = $schedout->m_timeout - $time_in->time;
									if($acchrs < 0 )
									{
										$acchrs = $acchrs + 12;
							
									}
								
								}

							}
						}
						else
						{
							$acchrs = $time_out->time - $time_in->time;

							if($acchrs < 0 )
							{
								$acchrs = $acchrs + 12;	
							}


						}
					}
							
					}
					$othrs = $othrs + $overtime;
					$hrs = $hrs + $acchrs;
					$total = $total + $acchrs + $overtime ;

				}
				$acchrs = $hrs;
				$overtime = $othrs;
				
			}

			return View::make('accumulated_hours')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('total',$total)
				->with('overtime',$overtime)
				->with('supervisor',$supervisor)
				->with('punchin',$punchin)
				->with('punchout',$punchout)
				->with('now',$now)
				->with('dateto',$dateto)
				->with('acchrs',$acchrs)
				->with('level', $level);
			}	
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}

	}

	public function postshowAccumulatedHours()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$acchrs = 0;
			$total = 0;
			
			
			$datefrom = Input::get('datefrom');
			$dateto = Input::get('dateto');

			//$dateto = new Datetime();
			//$datefrom = new DateTime();
			//$difference = date_diff($datefrom,$dateto);
			//$elapsed = $difference->format('%y years %m months %a days %h hours %i minutes %S seconds');
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$punchin = DB::table('punchstatus')
			->select('time_in_punch_id')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('employee_id','=',$id)
			//->where('date','=',$datefrom)
			->lists('time_in_punch_id');

			

			$punchout =DB::table('punchstatus')
			->select('time_out_punch_id')
			->whereBetween('punchstatus.date', array($datefrom, $dateto))
			->where('employee_id','=',$id)
			->lists('time_out_punch_id');
			


			if($punchin != null && $punchout != null)
			{
				$timein = DB::table('punches')
				->whereIn('id',$punchin)
				->get();
				
				$timeout = DB::table('punches')
				->whereIn('id',$punchout)
				->get();
				
				foreach($timein as $time_in)
				{
					foreach($timeout as $time_out)
					{
						$acchrs = $time_out->time - $time_in->time;
						if($acchrs < 0 )
						{
							
							$acchrs = $acchrs + 12;
							
						}
						
					}
					$total = $total + $acchrs;
				}
			}

			return View::make('accumulated_hours')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('total',$total)
				->with('supervisor',$supervisor)
				->with('punchin',$punchin)
				->with('punchout',$punchout)
				->with('acchrs',$acchrs)
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
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			return View::make('exceptions')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('supervisor', $supervisor)
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
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			return View::make('accruals')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('supervisor', $supervisor)
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
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$requests = DB::table('create_requests')->get();
		return View::make('reportsdaily')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('employees', $employees)
				->with('supervisor', $supervisor)
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
			$employees = DB::table('employs')->join('hierarchy_subordinates', 'employs.id', '=', 'hierarchy_subordinates.employee_id')
			->join('hierarchies', 'hierarchies.id', '=', 'hierarchy_subordinates.hierarchy_id' )
			->join('create_requests', 'create_requests.employee_id', '=', 'hierarchy_subordinates.employee_id')
			->where('create_requests.status', '=', 'pending')
			->where('supervisor_id', '=', $id)
			->get();
			$requests = DB::table('create_requests')->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			return View::make('request_authorization')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('employees', $employees)
				->with('supervisor', $supervisor)
				->with('requests', $requests);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}
	public function showRequestHistory()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$employees = DB::table('employs')->join('hierarchy_subordinates', 'employs.id', '=', 'hierarchy_subordinates.employee_id')
			->join('hierarchies', 'hierarchies.id', '=', 'hierarchy_subordinates.hierarchy_id' )
			->join('create_requests', 'create_requests.employee_id', '=', 'hierarchy_subordinates.employee_id')
			->where('supervisor_id', '=', $id)
			->get();
			$requests = DB::table('create_requests')->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			return View::make('requesthistory')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('employees', $employees)
				->with('supervisor', $supervisor)
				->with('requests', $requests);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

public function postRequestsAuthorization()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$employees = DB::table('employs')->join('hierarchy_subordinates', 'employs.id', '=', 'hierarchy_subordinates.employee_id')
			->join('hierarchies', 'hierarchies.id', '=', 'hierarchy_subordinates.hierarchy_id' )
			->join('create_requests', 'create_requests.employee_id', '=', 'hierarchy_subordinates.employee_id')
			->where('create_requests.status', '=', 'pending')
			->where('supervisor_id', '=', $id)
			->get();
			$requests = DB::table('create_requests')->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$status = Input::get('status');
			$emp_id = Input::get('emp_id');

			DB::statement('UPDATE create_requests SET status=:sur WHERE id=:res2',
				 array('sur' => $status, 'res2' => $emp_id) );


			Session::flash('messages', 'Request has been Approved');
			return View::make('request_authorization')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('employees', $employees)
				->with('supervisor', $supervisor)
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
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$employees = DB::table('employs')->where('level_id', '=', '0')->get();
			$requests = DB::table('create_requests')->get();
			return View::make('change_password')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('supervisor', $supervisor)
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
			$id = Session::get('empid', 'default');
			$downloads = DB::table('downloads')->get();
			$name = Session::get('empname', 'default');
			$level = Session::get('emplevel', 'default');
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			return View::make('downloads')
				->with('downloads', $downloads)
				->with('id', $id)
				->with('level', $level)
				->with('supervisor', $supervisor)
				->with('name', $name);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	public function postPdf()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			
			$id = Session::get('empid', 'default');
			$d_id = Input::get('download');
			$name = Session::get('empname', 'default');
			$level = Session::get('emplevel', 'default');
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$downloads = DB::table('downloads')->where('downloads.id', '=', $d_id)->get();
			return View::make('pdfviewer')
				->with('downloads', $downloads)
				->with('id', $id)
				->with('d_id', $d_id)
				->with('level', $level)
				->with('supervisor', $supervisor)
 				->with('name', $name);
 				
 		}
 	}

	public function showEmpdownload()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$empdownloads = DB::table('empdownloads')->where('empdownloads.employee_id', '=', $id)->get();
			return View::make('empdownloads')
				->with('empdownloads', $empdownloads)
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('supervisor', $supervisor)
				->with('level', $level);
			 
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	public function postEmpdownload()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$emp_id = Input::get('emp_id');
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$empdownloads = DB::table('empdownloads')->where('empdownloads.id', '=', $emp_id)->get();

			return View::make('empdownloadshow')
				->with('empdownloads', $empdownloads)
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('supervisor', $supervisor);
					
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	public function showEmployeeSummary()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {

		$id = Session::get('empid', 'default');
		$employs = DB::table('employs')->get();
		$departments = DB::table('departments')->get();
		$branches=DB::table('branches')->get();
		$jobtitles=DB::table('jobtitles')->get();
		$contracts=DB::table('contracts')->get();
		$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
		$currentid = Session::get('empid');
		$hierarchies = DB::table('hierarchies')
		->select('id')
		->where('supervisor_id','=',$currentid)
		->lists('id');
		$subordinates = DB::table('hierarchy_subordinates')
		->select('employee_id')
		->whereIn('hierarchy_id',$hierarchies)
		->lists('employee_id');
		$user = DB::table('employs')
		->whereIn('id',$subordinates)
		->get();
		$level = Session::get('emplevel', 'default');
		$name = Session::get('empname', 'default');
		return View::make('employeesummary')
			->with('branches',$branches)
		->with('hierarchies',$hierarchies)
		->with('subordinates',$subordinates)
		->with('departments',$departments)
		->with('employs',$employs)
		->with('user',$user)
		->with('jobtitles',$jobtitles)
		->with('level', $level)
		->with('id', $id)
		->with('name', $name)
		->with('supervisor', $supervisor)
		->with('contracts',$contracts);
				
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	public function showDtrSubordinates()
	{
		$id = Session::get('empid', 'default');
		$employs = DB::table('employs')->get();
		$departments = DB::table('departments')->get();
		$branches=DB::table('branches')->get();
		$jobtitles=DB::table('jobtitles')->get();
		$contracts=DB::table('contracts')->get();
		$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
		$currentid = Session::get('empid');
		$hierarchies = DB::table('hierarchies')
		->select('id')
		->where('supervisor_id','=',$currentid)
		->lists('id');
		$subordinates = DB::table('hierarchy_subordinates')
		->select('employee_id')
		->whereIn('hierarchy_id',$hierarchies)
		->lists('employee_id');
		$user = DB::table('employs')
		->whereIn('id',$subordinates)
		->get();
		$level = Session::get('emplevel', 'default');
		$name = Session::get('empname', 'default');
		return View::make('dtrsubordinates')
			->with('branches',$branches)
		->with('hierarchies',$hierarchies)
		->with('subordinates',$subordinates)
		->with('departments',$departments)
		->with('employs',$employs)
		->with('user',$user)
		->with('jobtitles',$jobtitles)
		->with('level', $level)
		->with('id', $id)
		->with('name', $name)
		->with('supervisor', $supervisor)
		->with('contracts',$contracts);
	}

	public function showScheduleQuery()
	{
		$id = Session::get('empid', 'default');
		$schedule_id = DB::table('empschedules')
		->select('schedule_id')
		->where('employee_id','=',$id)
		->lists('schedule_id');
		$schedule = DB::table('schedules')
		->whereIn('id',$schedule_id)
		->get();
		$currentid = Session::get('empid');
		$level = Session::get('emplevel', 'default');
		$name = Session::get('empname', 'default');
		$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
		return View::make('schedulequery')
		->with('level', $level)
		->with('id', $id)
		->with('name', $name)
		->with('supervisor', $supervisor)
		->with('schedule',$schedule)
		->with('schedule_id',$schedule_id);
		
	}
	public function showLeaveCredit()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$employees = DB::table('employs')->get();
			$credits = DB::table('leavecredits')->get();
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
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
						$diff = $diff - 12;
						if ($diff >= 12){
							$totyear= round($totyear = ($diff / 12), 0);
							$totmonth = round(($diff % 12), 0);
						foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){

									$sick_leave = (($totyear *15) + $totmonth * 1.25) - $credit->sick_leave;

									$vacation_leave = (($totyear *15) + $totmonth * 1.25) - $credit->vacation_leave;
								

								}
							}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
								$sick_leave = (($totyear *15) + $totmonth * 1.25);

								$vacation_leave = (($totyear *15) + $totmonth * 1.25) ;
								}
						
							if($vacation_leave >= 10)
							{
								foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){

								$force_counter = 5 * $totyear;
								$force_leave = 5;
								$vacation_leave = (($totyear *15) + $totmonth * 1.25) - $force_counter - $credit->vacation_leave;

								}
							}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$force_counter = 5 * $totyear;
									$force_leave = 5;
									$vacation_leave = (($totyear *15) + $totmonth * 1.25) - $force_counter;
								}

							}
							else {
								$force_leave = 0;
							}
						}
						if($diff < 12)
						{
							foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){
								$sick_leave = ($diff * 1.25) - $credit->sick_leave;
								$vacation_leave = ($diff * 1.25) - $credit->vacation_leave; }}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$sick_leave = $diff * 1.25;
									$vacation_leave = $diff * 1.25;
								}
								if($vacation_leave >= 10)
							{
								foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){
								$force_leave = 5;
								$vacation_leave = ($diff * 1.25) - $force_leave - $credit->vacation_leave;}}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$force_leave = 5;
									$vacation_leave = ($diff * 1.25) - $force_leave[$i];
								}
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
				->with('supervisor', $supervisor)
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