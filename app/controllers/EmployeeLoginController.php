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
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$ts=strtotime($now);
			$year = date('Y', $ts);
			$create_requests = DB::table('create_requests')->where('employee_id', '=', $id)->orderby('id', 'desc')->get();
			$request_types = DB::table('request_types')->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			return View::make('leavehistory')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('year', $year)
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

	public function postLeaveHistory()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$get_year = Input::get('year');
			$month = Input::get('month'); 
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$ts=strtotime($now);
			$year = date('Y', $ts);
			$create_requests = DB::table('create_requests')->where('employee_id', '=', $id)
			->where( DB::raw('MONTH(create_requests.request_date)'), '=', $month)
			->where( DB::raw('YEAR(create_requests.request_date)'), '=', $get_year)
			->orderby('id', 'desc')->get();
			$request_types = DB::table('request_types')->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			return View::make('leavehistory')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('year', $year)
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
			  	$month = date('m');
                $year = date('Y');
                $get_year = Session::get('year_query', 'default');
			$acchrs = 0;
			$total = 0;
			$overtime = 0;
			$date = date('d');
			$datenow = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$dateto = "";
			$to = "";
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
			 $curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));
                    $format_day = strtotime($curr_date);
                    $day_name = date('l', $format_day);
                
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
				if($day_name == 'Monday')
				{	
					$schedto = DB::table('schedules')
					->select('m_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Monday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				
				}
				if($day_name == 'Tuesday')
				{	
					$schedto = DB::table('schedules')
					->select('t_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Tuesday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
				if($day_name == 'Wednesday')
				{	
					$schedto = DB::table('schedules')
					->select('w_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Wednesday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
				if($day_name == 'Thursday')
				{	
					$schedto = DB::table('schedules')
					->select('th_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Thursday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
				if($day_name == 'Friday')
				{	
					$schedto = DB::table('schedules')
					->select('f_timeout')
					->where('id','=',$ifsched)
					->lists('f_timeout');
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Friday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
					
					
				}
				if($day_name == 'Saturday')
				{	
					$schedto = DB::table('schedules')
					->select('sat_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Saturday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
				if($day_name == 'Sunday')
				{	
					$schedto = DB::table('schedules')
					->select('sun_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Sunday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
			
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
			$breakin =DB::table('punchstatus')
			->select('break_in_punch_id')
			->where('employee_id','=',$id)
			->where('date','=',$now)
			->lists('break_in_punch_id');

			$breakout =DB::table('punchstatus')
			->select('break_out_punch_id')
			->where('employee_id','=',$id)
			->where('date','=',$now)
			->lists('break_out_punch_id');

		
			if($punchin != null && $punchout != null)
			{
				$timein = DB::table('punches')
				->where('id','=',$punchin)
				->get();
				
				$timeout = DB::table('punches')
				->where('id','=',$punchout)
				->get();

				$inbreak = DB::table('punches')
				->select('time')
				->where('id','=',$breakin)
				->get();

				$outbreak = DB::table('punches')
				->select('time')
				->where('id','=',$breakout)
				->get();
				
					//dito simula
				foreach($timein as $time_in)
				{
					foreach($timeout as $time_out)
					{
						foreach($schedto as $sched)
						{
						   
							$timeout = $time_out->time +12;

							if($timeout > $sched)
							{
								$breakminutes = 0;
								foreach($break as $breaks)
						   		{
						   			if($ifreqbreak == 'No')
						   			{
						   				
									//split break in in hours and minutes
										$separatedData = explode(':', $breaks->break_in);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakinMinutes = $minutesInHours + $minutesInDecimals;

										$separatedData = explode(':', $breaks->break_out);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakoutMinutes = $minutesInHours + $minutesInDecimals;
										$breakminutes = $breakoutMinutes - $breakinMinutes;
						   			}
						   			else
						   			{

						   				if($inbreak != null && $outbreak != null)
						   				{ 
						   					foreach($inbreak as $inbreaks)
						   					{
						   						$separatedData = explode(':', $inbreaks->time);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakinMinutes = $minutesInHours + $minutesInDecimals;
											}
											
											foreach($outbreak as $outbreaks)
						   					{
												$separatedData = explode(':', $outbreaks->time);
												$minutesInHours    = ($separatedData[0] +12) * 60;
												$minutesInDecimals = $separatedData[1];
												$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												
											}
											
											$breakminutes = $breakoutMinutes - $breakinMinutes;

										}
										else
										{
											$separatedData = explode(':', $breaks->break_in);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakinMinutes = $minutesInHours + $minutesInDecimals;

											$separatedData = explode(':', $breaks->break_out);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakoutMinutes = $minutesInHours + $minutesInDecimals;
											$breakminutes = $breakoutMinutes - $breakinMinutes;

										}
						   			}
						   	
								}

							    if($ifot != null)
							    {

								//if(count($allowedothr))
								
									foreach($allowedothr as $hr)
									{
										foreach($schedto as $schedout)
										{
											$allowed = $hr->Allowed_number_of_hours*60;
											$activeafter = $hr->active_after*60;
											$separatedData = explode(':', $schedout);
											$minutesInHours    = ($separatedData[0]) * 60;
											$minutesInDecimals = $separatedData[1];
											$totalMinutes1 = $minutesInHours + $minutesInDecimals;
											$span = ($totalMinutes1 + $allowed) + $activeafter;
											//$span = ($schedout + $hr->Allowed_number_of_hours) + $hr->active_after;
											$hours = floor($span / 60);
											$decimalMinutes = $span - floor($span/60) * 60;
				
											$spanhr = sprintf("%d:%02.0f", $hours, $decimalMinutes);

											if($timeout > $spanhr)
											{
												$overtimemin = ($span - $totalMinutes1) - $activeafter;
												$hours = floor($overtimemin / 60);
												$decimalMinutes = $overtimemin - floor($overtimemin/60) * 60;
				
												$overtimeMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
												$overtime = $overtimeMinutes;
												//$overtime = ($span - $schedout) - $hr->active_after;
											}
											else
											{	
												// Split time out in hours and minutes.
												$separatedData = explode(':', $time_out->time);
												$minutesInHours    = ($separatedData[0] +12	) * 60;
												$minutesInDecimals = $separatedData[1];
												$totalMinutes2 = $minutesInHours + $minutesInDecimals;
												
												$separatedData = explode(':', $schedout);
												$minutesInHours    = ($separatedData[0]) * 60;
												$minutesInDecimals = $separatedData[1];
												$totalMinutes1 = $minutesInHours + $minutesInDecimals;
											
												$activeafter = $hr->active_after*60;
												$overtimemin = ($totalMinutes2 - $totalMinutes1) - $activeafter;

												$hours = floor($overtimemin / 60);
												$decimalMinutes = $overtimemin - floor($overtimemin/60) * 60;
												
												$overtimeMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
												$overtime = $overtimeMinutes;

												//$overtime = ($timeout - $schedout) - $hr->active_after;
											}
											$separatedData = explode(':', $sched);


											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];

											$totalMinutes = $minutesInHours + $minutesInDecimals;
									
											// Split time out in hours and minutes.
											$separatedData = explode(':', $time_in->time);

											$minutesInHours    = ($separatedData[0] +12	) * 60;
											$minutesInDecimals = $separatedData[1];
		
											$totalMinutes2 = $minutesInHours + $minutesInDecimals;
									
											//convert minutes to hours:minutes
											$mulated = $totalMinutes - $totalMinutes2;
											
											$mulated = $mulated + 720;
											$mulated = $mulated - $breakminutes;
											$hours = floor($mulated / 60);
											$decimalMinutes = $mulated - floor($mulated/60) * 60;
				
											$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);

											$acchrs = $hoursMinutes;
											$total = $mulated + $overtimemin;
											$hours = floor($total / 60);
											$decimalMinutes = $total - floor($total/60) * 60;
											
											$totalMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
											$total = $totalMinutes;
											//$acchrs = $schedout - $time_in->time;
											//if($acchrs < 0 )
											//{
											//	$acchrs = $acchrs + 12;
											//}

											//$total = $total + $acchrs + $overtime;
										} 
									}
									
								}
								else
								{
									$separatedData = explode(':', $sched);


									$minutesInHours    = $separatedData[0] * 60;
									$minutesInDecimals = $separatedData[1];

									$totalMinutes = $minutesInHours + $minutesInDecimals;
									
									// Split time out in hours and minutes.
									$separatedData = explode(':', $time_in->time);

									$minutesInHours    = ($separatedData[0] +12	) * 60;
									$minutesInDecimals = $separatedData[1];

									$totalMinutes2 = $minutesInHours + $minutesInDecimals;
									
									//convert minutes to hours:minutes
									$mulated = $totalMinutes - $totalMinutes2;
									
									$mulated = $mulated + 720;
									$mulated = $mulated - $breakminutes;
									$hours = floor($mulated / 60);
									$decimalMinutes = $mulated - floor($mulated/60) * 60;
				
									$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);

									$acchrs = $hoursMinutes;
									$total = $hoursMinutes;
									//foreach($schedto as $schedout)
									//{
									//	$acchrs = $schedout - $time_in->time;
									//	if($acchrs < 0 )
									//	{
									//		$acchrs = $acchrs + 12;
							
									//	}
									//	$total = $total + $acchrs + $overtime;
									//}

								}
							
							}
							else
							{
								$breakminutes = 0;
								foreach($break as $breaks)
						   		{
						   			if($ifreqbreak == 'No')
						   			{
						   				
									//split break in in hours and minutes
										$separatedData = explode(':', $breaks->break_in);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakinMinutes = $minutesInHours + $minutesInDecimals;

										$separatedData = explode(':', $breaks->break_out);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakoutMinutes = $minutesInHours + $minutesInDecimals;
										$breakminutes = $breakoutMinutes - $breakinMinutes;
						   			}
						   			else
						   			{

						   				if($inbreak != null && $outbreak != null)
						   				{ 
						   					foreach($inbreak as $inbreaks)
						   					{
						   						$separatedData = explode(':', $inbreaks->time);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakinMinutes = $minutesInHours + $minutesInDecimals;
											}
											
											foreach($outbreak as $outbreaks)
						   					{
												$separatedData = explode(':', $outbreaks->time);
												$minutesInHours    = ($separatedData[0] +12) * 60;
												$minutesInDecimals = $separatedData[1];
												$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												
											}
											
											$breakminutes = $breakoutMinutes - $breakinMinutes;

										}
										else
										{
											$separatedData = explode(':', $breaks->break_in);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakinMinutes = $minutesInHours + $minutesInDecimals;

											$separatedData = explode(':', $breaks->break_out);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakoutMinutes = $minutesInHours + $minutesInDecimals;
											$breakminutes = $breakoutMinutes - $breakinMinutes;

										}
						   			}
						   	
								}

								// Split time in in hours and minutes.
							$separatedData = explode(':', $time_in->time);
							$minutesInHours    = $separatedData[0] * 60;
							$minutesInDecimals = $separatedData[1];
							$totalMinutes = $minutesInHours + $minutesInDecimals;

							// Split time out in hours and minutes.
							$separatedData = explode(':', $time_out->time);
							$minutesInHours    = $separatedData[0] * 60;
							$minutesInDecimals = $separatedData[1];
							$totalMinutes2 = $minutesInHours + $minutesInDecimals;
							
							//convert minutes to hours:minutes
							$mulated = $totalMinutes2 - $totalMinutes;
							$mulated = ($mulated + 720)-$breakminutes;

							$hours = floor($mulated / 60);
							$decimalMinutes = $mulated - floor($mulated/60) * 60;
							
							$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
							$acchrs = $hoursMinutes ;
							$total = $hoursMinutes;

							
								//$acchrs = $time_out->time - $time_in->time;
								//if($acchrs < 0 )
								//{
								//	$acchrs = $acchrs + 12;
								//}
								//$total = $total + $acchrs + $overtime;
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
				->with('to',$to)
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

	//public function hoursToMinutes($time_in)
	//{
	//	$totalMinutes = 0;
		

	//					return $this->hoursToMinutes($totalMinutes);

	//}

	public function postshowAccumulatedHours()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) 
		{
			$acchrs = 0;
			$total = 0;
			$overtime = 0;
			$hrs = 0;
			$othrs = 0;
			$year = date('Y');
			$date = date('d');
			$month = date('m');
			$totalminutes = 0;
			$overtimemin =0;
			$curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));
            $format_day = strtotime($curr_date);
            $day_name = date('l', $format_day);
			$datefrom = Input::get('datefrom');
			$dateto = Input::get('dateto');
			$now = Input::get('datefrom');
			$to = "to";
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
				if($day_name == 'Monday')
				{	
					$schedto = DB::table('schedules')
					->select('m_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Monday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				
				}
				if($day_name == 'Tuesday')
				{	
					$schedto = DB::table('schedules')
					->select('t_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Tuesday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
				if($day_name == 'Wednesday')
				{	
					$schedto = DB::table('schedules')
					->select('w_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Wednesday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
				if($day_name == 'Thursday')
				{	
					$schedto = DB::table('schedules')
					->select('th_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Thursday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
				if($day_name == 'Friday')
				{	
					$schedto = DB::table('schedules')
					->select('f_timeout')
					->where('id','=',$ifsched)
					->lists('f_timeout');
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Friday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
					
					
				}
				if($day_name == 'Saturday')
				{	
					$schedto = DB::table('schedules')
					->select('sat_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Saturday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
				if($day_name == 'Sunday')
				{	
					$schedto = DB::table('schedules')
					->select('sun_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Sunday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
				}
			
			}
			$punchin = DB::table('punchstatus')
			->select('time_in_punch_id')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('employee_id','=',$id)
			->lists('time_in_punch_id');
			$punchout =DB::table('punchstatus')
			->select('time_out_punch_id')
			->whereBetween('punchstatus.date', array($datefrom, $dateto))
			->where('employee_id','=',$id)
			->lists('time_out_punch_id');
			$breakin =DB::table('punchstatus')
			->select('break_in_punch_id')
			->where('employee_id','=',$id)
			->whereBetween('punchstatus.date', array($datefrom, $dateto))
			->lists('break_in_punch_id');

			$breakout =DB::table('punchstatus')
			->select('break_out_punch_id')
			->where('employee_id','=',$id)
			->whereBetween('punchstatus.date', array($datefrom, $dateto))
			->lists('break_out_punch_id');
			if($punchin != null && $punchout != null)
			{
				$timein = DB::table('punches')
				->whereIn('id',$punchin)
				->get();
				
				$timeout = DB::table('punches')
				->whereIn('id',$punchout)
				->get();

				$inbreak = DB::table('punches')
				->select('time')
				->where('id','=',$breakin)
				->get();

				$outbreak = DB::table('punches')
				->select('time')
				->where('id','=',$breakout)
				->get();
				
				foreach($timeout as $time_out)
				{
					foreach($timein as $time_in)
					{
						foreach($schedto as $sched)
						{

							$timeout = $time_out->time +12;
							if($timeout > $sched)
							{
								$breakminutes = 0;
								foreach($break as $breaks)
						   		{
						   			if($ifreqbreak == 'No')
						   			{
						   				
									//split break in in hours and minutes
										$separatedData = explode(':', $breaks->break_in);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakinMinutes = $minutesInHours + $minutesInDecimals;

										$separatedData = explode(':', $breaks->break_out);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakoutMinutes = $minutesInHours + $minutesInDecimals;
										$breakminutes = $breakoutMinutes - $breakinMinutes;
						   			}
						   			else
						   			{

						   				if($inbreak != null && $outbreak != null)
						   				{ 
						   					foreach($inbreak as $inbreaks)
						   					{
						   						$separatedData = explode(':', $inbreaks->time);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakinMinutes = $minutesInHours + $minutesInDecimals;
											}
											
											foreach($outbreak as $outbreaks)
						   					{
												$separatedData = explode(':', $outbreaks->time);
												$minutesInHours    = ($separatedData[0] +12) * 60;
												$minutesInDecimals = $separatedData[1];
												$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												
											}
											
											$breakminutes = $breakoutMinutes - $breakinMinutes;

										}
										else
										{
											$separatedData = explode(':', $breaks->break_in);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakinMinutes = $minutesInHours + $minutesInDecimals;

											$separatedData = explode(':', $breaks->break_out);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakoutMinutes = $minutesInHours + $minutesInDecimals;
											$breakminutes = $breakoutMinutes - $breakinMinutes;

										}
						   			}
						   	
								}

								if($ifot != null)
								{
									foreach($allowedothr as $hr)
									{
										foreach($schedto as $schedout)
										{
											$allowed = $hr->Allowed_number_of_hours*60;
											$activeafter = $hr->active_after*60;
											$separatedData = explode(':', $schedout);
											$minutesInHours    = ($separatedData[0]) * 60;
											$minutesInDecimals = $separatedData[1];
											$totalMinutes1 = $minutesInHours + $minutesInDecimals;
											$span = ($totalMinutes1 + $allowed) + $activeafter;
											//$span = ($schedout + $hr->Allowed_number_of_hours) + $hr->active_after;
											$hours = floor($span / 60);
											$decimalMinutes = $span - floor($span/60) * 60;
											$spanhr = sprintf("%d:%02.0f", $hours, $decimalMinutes);
										//$span = ($schedout->m_timeout + $hr->Allowed_number_of_hours) + $hr->active_after;
											
											//if($time_out->time > $span)
											//{
											//	$overtime = ($span - $schedout->m_timeout) - $hr->active_after;
											//}
											if($timeout > $spanhr)
											{
												$overtimemin = ($span - $totalMinutes1) - $activeafter;
												$hours = floor($overtimemin / 60);
												$decimalMinutes = $overtimemin - floor($overtimemin/60) * 60;
				
												$overtimeMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
												
												//$overtime = ($span - $schedout) - $hr->active_after;
											}
											else
											{	// Split time out in hours and minutes.
												$separatedData = explode(':', $time_out->time);
												$minutesInHours    = ($separatedData[0] +12	) * 60;
												$minutesInDecimals = $separatedData[1];
												$totalMinutes2 = $minutesInHours + $minutesInDecimals;
												
												$separatedData = explode(':', $schedout);
												$minutesInHours    = ($separatedData[0]) * 60;
												$minutesInDecimals = $separatedData[1];
												$totalMinutes1 = $minutesInHours + $minutesInDecimals;
											
												$activeafter = $hr->active_after*60;
												$overtimemin = ($totalMinutes2 - $totalMinutes1) - $activeafter;

												$hours = floor($overtimemin / 60);
												$decimalMinutes = $overtimemin - floor($overtimemin/60) * 60;
												
												$overtimeMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
												

												//$overtime = ($time_out->time - $schedout->m_timeout) - $hr->active_after;
											}
											$separatedData = explode(':', $sched);


											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];

											$totalMinutes = $minutesInHours + $minutesInDecimals;
									
											// Split time out in hours and minutes.
											$separatedData = explode(':', $time_in->time);

											$minutesInHours    = ($separatedData[0] +12	) * 60;
											$minutesInDecimals = $separatedData[1];
		
											$totalMinutes2 = $minutesInHours + $minutesInDecimals;
									
											//convert minutes to hours:minutes
											$mulated = $totalMinutes - $totalMinutes2;
											
											$mulated = $mulated + 720;
											$mulated = $mulated - $breakminutes;
											$hours = floor($mulated / 60);
											$decimalMinutes = $mulated - floor($mulated/60) * 60;
											
											$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);

											$acchrs = $hoursMinutes;
											$total = $mulated + $overtime;
											$hours = floor($total / 60);
											$decimalMinutes = $total - floor($total/60) * 60;
											
											$totalMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
											//$total = $totalMinutes;

											//$acchrs = $schedout->m_timeout - $time_in->time;
								
											//if($acchrs < 0 )
											//{
											//	$acchrs = $acchrs + 12;
											//}
										}
									}
								}
								else
								{
									$separatedData = explode(':', $sched);


									$minutesInHours    = $separatedData[0] * 60;
									$minutesInDecimals = $separatedData[1];

									$totalMinutes = $minutesInHours + $minutesInDecimals;
									
									// Split time out in hours and minutes.
									$separatedData = explode(':', $time_in->time);

									$minutesInHours    = ($separatedData[0] +12	) * 60;
									$minutesInDecimals = $separatedData[1];

									$totalMinutes2 = $minutesInHours + $minutesInDecimals;
									
									//convert minutes to hours:minutes
									$mulated = $totalMinutes - $totalMinutes2;
									
									$mulated = $mulated + 720;
									$mulated = $mulated - $breakminutes;
									$hours = floor($mulated / 60);
									$decimalMinutes = $mulated - floor($mulated/60) * 60;
									
									$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);

									$acchrs = $hoursMinutes;
									$total = $hoursMinutes;
									//foreach($schedto as $schedout)
									//{
									//	$acchrs = $schedout->m_timeout - $time_in->time;
									//	if($acchrs < 0 )
									//	{
									//		$acchrs = $acchrs + 12;
							
										//}
								
									//}
								}
							}
							else
							{
								$breakminutes = 0;
								foreach($break as $breaks)
						   		{
						   			if($ifreqbreak == 'No')
						   			{
						   				
									//split break in in hours and minutes
										$separatedData = explode(':', $breaks->break_in);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakinMinutes = $minutesInHours + $minutesInDecimals;

										$separatedData = explode(':', $breaks->break_out);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakoutMinutes = $minutesInHours + $minutesInDecimals;
										$breakminutes = $breakoutMinutes - $breakinMinutes;
						   			}
						   			else
						   			{

						   				if($inbreak != null && $outbreak != null)
						   				{ 
						   					foreach($inbreak as $inbreaks)
						   					{
						   						$separatedData = explode(':', $inbreaks->time);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakinMinutes = $minutesInHours + $minutesInDecimals;
											}
											
											foreach($outbreak as $outbreaks)
						   					{
												$separatedData = explode(':', $outbreaks->time);
												$minutesInHours    = ($separatedData[0] +12) * 60;
												$minutesInDecimals = $separatedData[1];
												$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												
											}
											
											$breakminutes = $breakoutMinutes - $breakinMinutes;

										}
										else
										{
											$separatedData = explode(':', $breaks->break_in);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakinMinutes = $minutesInHours + $minutesInDecimals;

											$separatedData = explode(':', $breaks->break_out);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakoutMinutes = $minutesInHours + $minutesInDecimals;
											$breakminutes = $breakoutMinutes - $breakinMinutes;

										}
						   			}
						   	
								}
								$separatedData = explode(':', $time_in->time);
								$minutesInHours    = $separatedData[0] * 60;
								$minutesInDecimals = $separatedData[1];
								$totalMinutes = $minutesInHours + $minutesInDecimals;

							// Split time out in hours and minutes.
								$separatedData = explode(':', $time_out->time);
								$minutesInHours    = $separatedData[0] * 60;
								$minutesInDecimals = $separatedData[1];
								$totalMinutes2 = $minutesInHours + $minutesInDecimals;
							
							//convert minutes to hours:minutes
								$mulated = $totalMinutes2 - $totalMinutes;
								$mulated = ($mulated + 720)-$breakminutes;
								$overtimemin = 0;
								//$hours = floor($mulated / 60);
								//$decimalMinutes = $mulated - floor($mulated/60) * 60;
								
								//$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
								//$acchrs = $hoursMinutes ;
								//$total = $hoursMinutes;
								
								//$acchrs = $time_out->time - $time_in->time;
								//if($acchrs < 0 )
								//{
								//	$acchrs = $acchrs + 12;	
								//}							
							}
						}
					}

					$othrs = $othrs + $overtimemin;
					$hrs = $hrs + $mulated;
					$totalminutes = $totalminutes + $mulated + $overtimemin;

					$hours = floor($totalminutes / 60);
					$decimalMinutes = $totalminutes - floor($totalminutes/60) * 60;
					$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
					$total = $hoursMinutes;	

									
				}

				$hours = floor($hrs / 60);
				$decimalMinutes = $hrs - floor($hrs/60) * 60;
				$acchrsMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
				$acchrs = $acchrsMinutes;
				
				$hours = floor($othrs / 60);
				$decimalMinutes = $othrs - floor($othrs/60) * 60;
				$otMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
				$overtime = $otMinutes;
				
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
				->with('level', $level)
				->with('to',$to);
				
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}//show accumulated hours (post)

	public function showAccumulatedSub()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) 
		{
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$acchrs = 0;
			$total = 0;
			$overtime = 0;
			$to = "";
			$dateto="";
			$datenow = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $datenow->format('Y-m-d');
			$month = date('m');
            $year = date('Y');
			$date = date('d');
			$curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));
            $format_day = strtotime($curr_date);
            $day_name = date('l', $format_day);
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$hierarchies = DB::table('hierarchies')
			->select('id')
			->where('supervisor_id','=',$id)
			->lists('id');
			$subordinates = DB::table('hierarchy_subordinates')
			->select('employee_id')
			->whereIn('hierarchy_id',$hierarchies)
			->lists('employee_id');
			$user = DB::table('employs')
			->whereIn('id',$subordinates)
			->get();
			$employers=array();
			$employee_lists = array();
			
			
			foreach($user as $employs)
			{	
				$acchrs = 0;
				$total = 0;
				$overtime = 0;
				$ifot = DB::table('overtime_subordinates')
				->select('overtime_id')
				->where('employee_id','=',$employs->id)
				->lists('overtime_id');
				if($ifot != null)
				{
					$allowedothr = DB::table('overtime_policies')
					->where('id','=',$ifot)
					->get();
				}
				$ifsched = DB::table('empschedules')
				->select('schedule_id')
				->where('employee_id','=',$employs->id)
				->lists('schedule_id');
				if($ifsched != null)
				{
					if($day_name == 'Monday')
					{	
						$schedto = DB::table('schedules')
						->select('m_timeout')
						->where('id','=',$ifsched)
						->get();
						$break= DB::table('schedules')
						->join('breaks','schedules.id','=','breaks.schedule_id')
						->select('breaks.break_in','breaks.break_out')
						->where('day','=','Monday')
						->get();
						$ifreqbreak = DB::table('schedules')
						->select('require_break_punches')
						->where('id','=',$ifsched)
						->get();
					}
					if($day_name == 'Tuesday')
					{	
						$schedto = DB::table('schedules')
						->select('t_timeout')
						->where('id','=',$ifsched)
						->get();
						$break= DB::table('schedules')
						->join('breaks','schedules.id','=','breaks.schedule_id')
						->select('breaks.break_in','breaks.break_out')
						->where('day','=','Tuesday')
						->get();
						$ifreqbreak = DB::table('schedules')
						->select('require_break_punches')
						->where('id','=',$ifsched)
						->get();
					}
					if($day_name == 'Wednesday')
					{	
						$schedto = DB::table('schedules')
						->select('w_timeout')
						->where('id','=',$ifsched)
						->get();
						$break= DB::table('schedules')
						->join('breaks','schedules.id','=','breaks.schedule_id')
						->select('breaks.break_in','breaks.break_out')
						->where('day','=','Wednesday')
						->get();
						$ifreqbreak = DB::table('schedules')
						->select('require_break_punches')
						->where('id','=',$ifsched)
						->get();
					}
					if($day_name == 'Thursday')
					{	
						$schedto = DB::table('schedules')
						->select('th_timeout')
						->where('id','=',$ifsched)
						->get();
						$break= DB::table('schedules')
						->join('breaks','schedules.id','=','breaks.schedule_id')
						->select('breaks.break_in','breaks.break_out')
						->where('day','=','Thursday')
						->get();
						$ifreqbreak = DB::table('schedules')
						->select('require_break_punches')
						->where('id','=',$ifsched)
						->get();
					}
					if($day_name == 'Friday')
					{	
						$schedto = DB::table('schedules')
						->select('f_timeout')
						->where('id','=',$ifsched)
						->lists('f_timeout');
						$break= DB::table('schedules')
						->join('breaks','schedules.id','=','breaks.schedule_id')
						->select('breaks.break_in','breaks.break_out')
						->where('day','=','Friday')
						->get();
						$ifreqbreak = DB::table('schedules')
						->select('require_break_punches')
						->where('id','=',$ifsched)
						->get();
					}
					if($day_name == 'Saturday')
					{	
						$schedto = DB::table('schedules')
						->select('sat_timeout')
						->where('id','=',$ifsched)
						->get();
						$break= DB::table('schedules')
						->join('breaks','schedules.id','=','breaks.schedule_id')
						->select('breaks.break_in','breaks.break_out')
						->where('day','=','Saturday')
						->get();
						$ifreqbreak = DB::table('schedules')
						->select('require_break_punches')
						->where('id','=',$ifsched)
						->get();
					}
					if($day_name == 'Sunday')
					{	
						$schedto = DB::table('schedules')
						->select('sun_timeout')
						->where('id','=',$ifsched)
						->get();
						$break= DB::table('schedules')
						->join('breaks','schedules.id','=','breaks.schedule_id')
						->select('breaks.break_in','breaks.break_out')
						->where('day','=','Sunday')
						->get();
						$ifreqbreak = DB::table('schedules')
						->select('require_break_punches')
						->where('id','=',$ifsched)
						->get();
					}
				}
				$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
				$punchin = DB::table('punchstatus')
				->select('time_in_punch_id')
				->where('employee_id','=',$employs->id)
				->where('date','=',$now)
				->lists('time_in_punch_id');
				$punchout =DB::table('punchstatus')
				->select('time_out_punch_id')
				->where('employee_id','=',$employs->id)
				->where('date','=',$now)
				->lists('time_out_punch_id');

				$breakin =DB::table('punchstatus')
				->select('break_in_punch_id')
				->where('employee_id','=',$employs->id)
				->where('date','=',$now)
				->lists('break_in_punch_id');

				$breakout =DB::table('punchstatus')
				->select('break_out_punch_id')
				->where('employee_id','=',$employs->id)
				->where('date','=',$now)
				->lists('break_out_punch_id');

				if($punchin != null && $punchout != null)
				{
					$timein = DB::table('punches')
					->where('id','=',$punchin)
					->get();

					$timeout = DB::table('punches')
					->where('id','=',$punchout)
					->get();

					$inbreak = DB::table('punches')
					->select('time')
					->where('id','=',$breakin)
					->get();

					$outbreak = DB::table('punches')
					->select('time')
					->where('id','=',$breakout)
					->get();

					foreach($timein as $time_in)
					{
						foreach($timeout as $time_out)
						{
							foreach($schedto as $sched)
							{
								$timeout = $time_out->time +12;
								if($timeout > $sched)
								{
									$breakminutes = 0;
									foreach($break as $breaks)
						   			{
						   				if($ifreqbreak == 'No')
						   				{
						   				
									//split break in in hours and minutes
											$separatedData = explode(':', $breaks->break_in);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakinMinutes = $minutesInHours + $minutesInDecimals;

											$separatedData = explode(':', $breaks->break_out);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakoutMinutes = $minutesInHours + $minutesInDecimals;
											$breakminutes = $breakoutMinutes - $breakinMinutes;
						   				}
						   				else
						   				{

						   					if($inbreak != null && $outbreak != null)
						   					{ 
						   						foreach($inbreak as $inbreaks)
						   						{
						   							$separatedData = explode(':', $inbreaks->time);
													$minutesInHours    = $separatedData[0] * 60;
													$minutesInDecimals = $separatedData[1];
													$breakinMinutes = $minutesInHours + $minutesInDecimals;
												}
											
												foreach($outbreak as $outbreaks)
						   						{
													$separatedData = explode(':', $outbreaks->time);
													$minutesInHours    = ($separatedData[0] +12) * 60;
													$minutesInDecimals = $separatedData[1];
													$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												
												}
											
												$breakminutes = $breakoutMinutes - $breakinMinutes;

											}
											else
											{
												$separatedData = explode(':', $breaks->break_in);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakinMinutes = $minutesInHours + $minutesInDecimals;

												$separatedData = explode(':', $breaks->break_out);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												$breakminutes = $breakoutMinutes - $breakinMinutes;
											}
						   				}
									}
									if($ifot != null)
									{
										foreach($allowedothr as $hr)
										{
											foreach($schedto as $schedout)
											{
												$allowed = $hr->Allowed_number_of_hours*60;
												$activeafter = $hr->active_after*60;
												$separatedData = explode(':', $schedout);
												$minutesInHours    = ($separatedData[0]) * 60;
												$minutesInDecimals = $separatedData[1];
												$totalMinutes1 = $minutesInHours + $minutesInDecimals;
												$span = ($totalMinutes1 + $allowed) + $activeafter;
												//$span = ($schedout + $hr->Allowed_number_of_hours) + $hr->active_after;
												$hours = floor($span / 60);
												$decimalMinutes = $span - floor($span/60) * 60;
												$spanhr = sprintf("%d:%02.0f", $hours, $decimalMinutes);
												//$span = ($schedout->m_timeout + $hr->Allowed_number_of_hours) + $hr->active_after;
												if($timeout > $spanhr)
												{
													$overtimemin = ($span - $totalMinutes1) - $activeafter;
													$hours = floor($overtimemin / 60);
													$decimalMinutes = $overtimemin - floor($overtimemin/60) * 60;
				
													$overtimeMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
													
													//$overtime = ($span - $schedout->m_timeout) - $hr->active_after;
												}
												else
												{	
													$separatedData = explode(':', $time_out->time);
													$minutesInHours    = ($separatedData[0] +12	) * 60;
													$minutesInDecimals = $separatedData[1];
													$totalMinutes2 = $minutesInHours + $minutesInDecimals;
												
													$separatedData = explode(':', $schedout);
													$minutesInHours    = ($separatedData[0]) * 60;
													$minutesInDecimals = $separatedData[1];
													$totalMinutes1 = $minutesInHours + $minutesInDecimals;
											
													$activeafter = $hr->active_after*60;
													$overtimemin = ($totalMinutes2 - $totalMinutes1) - $activeafter;

													$hours = floor($overtimemin / 60);
													$decimalMinutes = $overtimemin - floor($overtimemin/60) * 60;
												
													$overtimeMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
													$overtime = $overtimeMinutes;
													//$overtime = ($time_out->time - $schedout->m_timeout) - $hr->active_after;
												}
												$separatedData = explode(':', $sched);

												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];

												$totalMinutes = $minutesInHours + $minutesInDecimals;
									
											// Split time out in hours and minutes.
												$separatedData = explode(':', $time_in->time);

												$minutesInHours    = ($separatedData[0] +12	) * 60;
												$minutesInDecimals = $separatedData[1];
		
												$totalMinutes2 = $minutesInHours + $minutesInDecimals;
									
											//convert minutes to hours:minutes
												$mulated = $totalMinutes - $totalMinutes2;
											
												$mulated = $mulated + 720;
												$mulated = $mulated - $breakminutes;
												$hours = floor($mulated / 60);
												$decimalMinutes = $mulated - floor($mulated/60) * 60;
				
												$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);

												$acchrs = $hoursMinutes;
												$total = $mulated + $overtimemin;
												$hours = floor($total / 60);
												$decimalMinutes = $total - floor($total/60) * 60;
											
												$totalMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
												$total = $totalMinutes;
												//$acchrs = $schedout->m_timeout - $time_in->time;
												//if($acchrs < 0 )
												//{
												//	$acchrs = $acchrs + 12;
												//}
												//$total = $total + $acchrs + $overtime;
											} 
										}
									}
									else
									{
										$separatedData = explode(':', $sched);


										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];

										$totalMinutes = $minutesInHours + $minutesInDecimals;
									
										// Split time out in hours and minutes.
										$separatedData = explode(':', $time_in->time);

										$minutesInHours    = ($separatedData[0] +12	) * 60;
										$minutesInDecimals = $separatedData[1];

										$totalMinutes2 = $minutesInHours + $minutesInDecimals;
									
									//convert minutes to hours:minutes
										$mulated = $totalMinutes - $totalMinutes2;
									
										$mulated = $mulated + 720;
										$mulated = $mulated - $breakminutes;
										$hours = floor($mulated / 60);
										$decimalMinutes = $mulated - floor($mulated/60) * 60;
				
										$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);

										$acchrs = $hoursMinutes;
										$total = $hoursMinutes;
										//foreach($schedto as $schedout)
										//{
										//$acchrs = $schedout->m_timeout - $time_in->time;
										//if($acchrs < 0 )
										//{
										//	$acchrs = $acchrs + 12;
							
										//}
										//$total = $total + $acchrs + $overtime;
										//}
									}
							
								}
								else
								{
									$breakminutes = 0;
									foreach($break as $breaks)
						   			{
						   				if($ifreqbreak == 'No')
						   				{
						   				
									//split break in in hours and minutes
											$separatedData = explode(':', $breaks->break_in);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakinMinutes = $minutesInHours + $minutesInDecimals;

											$separatedData = explode(':', $breaks->break_out);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakoutMinutes = $minutesInHours + $minutesInDecimals;
											$breakminutes = $breakoutMinutes - $breakinMinutes;
						   				}
						   				else
						   				{

						   					if($inbreak != null && $outbreak != null)
						   					{ 
						   						foreach($inbreak as $inbreaks)
						   						{
						   							$separatedData = explode(':', $inbreaks->time);
													$minutesInHours    = $separatedData[0] * 60;
													$minutesInDecimals = $separatedData[1];
													$breakinMinutes = $minutesInHours + $minutesInDecimals;
												}
											
												foreach($outbreak as $outbreaks)
						   						{
													$separatedData = explode(':', $outbreaks->time);
													$minutesInHours    = ($separatedData[0] +12) * 60;
													$minutesInDecimals = $separatedData[1];
													$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												
												}
											
												$breakminutes = $breakoutMinutes - $breakinMinutes;

											}
											else
											{
												$separatedData = explode(':', $breaks->break_in);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakinMinutes = $minutesInHours + $minutesInDecimals;

												$separatedData = explode(':', $breaks->break_out);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												$breakminutes = $breakoutMinutes - $breakinMinutes;
											}
						   				}
									}
									// Split time in in hours and minutes.
									$separatedData = explode(':', $time_in->time);
									$minutesInHours    = $separatedData[0] * 60;
									$minutesInDecimals = $separatedData[1];
									$totalMinutes = $minutesInHours + $minutesInDecimals;

							// Split time out in hours and minutes.
									$separatedData = explode(':', $time_out->time);
									$minutesInHours    = $separatedData[0] * 60;
									$minutesInDecimals = $separatedData[1];
									$totalMinutes2 = $minutesInHours + $minutesInDecimals;
							
							//convert minutes to hours:minutes
									$mulated = $totalMinutes2 - $totalMinutes;
									$mulated = ($mulated + 720)-$breakminutes;

									$hours = floor($mulated / 60);
									$decimalMinutes = $mulated - floor($mulated/60) * 60;
							
									$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
									$acchrs = $hoursMinutes;
									$total = $hoursMinutes;
									//$acchrs = $time_out->time - $time_in->time;
									//if($acchrs < 0 )
									//{
									//	$acchrs = $acchrs + 12;
									//}
									//$total = $total + $acchrs + $overtime;
								}
							}
						}
					}
				}
				else
				{
					$acchrs= 0;
					$overtime = 0;
					$total = 0;
				}
				$employers = array('id' => $employs->lname, 'name'=> $employs->fname,'total' => $total, 'acchrs' => $acchrs,'overtime' =>$overtime);
				array_push($employee_lists, $employers);
			}
			
			return View::make('accmltddhrssubodinates')
				->with('id', $id)
				
				->with('name', $name)
				->with('email', $email)
				->with('supervisor', $supervisor)
				->with('now',$now)
				->with('level', $level)
				->with('hierarchies',$hierarchies)
				->with('subordinates',$subordinates)
				->with('total',$total)
				->with('overtime',$overtime)
				->with('acchrs',$acchrs)
				->with('employee_lists',$employee_lists)
				->with('to',$to)
				->with('dateto',$dateto)
				->with('user',$user);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
		
	}//show accumulated hours (subordinates)

	public function postshowAccumulatedSub()
	{	
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) 
		{
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$year = date('Y');
			$date = date('d');
			$month = date('m');
			$acchrs = 0;
			$total = 0;
			$overtime = 0;
			$othrs = 0;
			$hrs = 0;
			$totalminutes = 0;
			$overtimemin =0;
			$curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));
            $format_day = strtotime($curr_date);
            $day_name = date('l', $format_day);
			$datenow = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$datefrom = Input::get('datefrom');
			$dateto = Input::get('dateto');
			$now = Input::get('datefrom');
			$to = "to";
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$hierarchies = DB::table('hierarchies')
			->select('id')
			->where('supervisor_id','=',$id)
			->lists('id');
			$subordinates = DB::table('hierarchy_subordinates')
			->select('employee_id')
			->whereIn('hierarchy_id',$hierarchies)
			->lists('employee_id');
			$user = DB::table('employs')
			->whereIn('id',$subordinates)
			->get();
			$employers=array();
			$employee_lists = array();
		
			
			foreach($user as $employs)
			{	
				$hrs = 0;
				$othrs =0;
				$total = 0;
				$overtime = 0;

				$ifot = DB::table('overtime_subordinates')
				->select('overtime_id')
				->where('employee_id','=',$employs->id)
				->lists('overtime_id');
				if($ifot != null)
				{
					$allowedothr = DB::table('overtime_policies')
					->where('id','=',$ifot)
					->get();
				}
				$ifsched = DB::table('empschedules')
				->select('schedule_id')
				->where('employee_id','=',$employs->id)
				->lists('schedule_id');
				if($ifsched != null)
				{
					if($day_name == 'Monday')
					{	
					$schedto = DB::table('schedules')
					->select('m_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Monday')
					->get();
				
					}
					if($day_name == 'Tuesday')
					{	
					$schedto = DB::table('schedules')
					->select('t_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Tuesday')
					->get();
					}
					if($day_name == 'Wednesday')
					{	
					$schedto = DB::table('schedules')
					->select('w_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Wednesday')
					->get();
					}
					if($day_name == 'Thursday')
					{	
					$schedto = DB::table('schedules')
					->select('th_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Thursday')
					->get();
					}
					if($day_name == 'Friday')
					{	
					$schedto = DB::table('schedules')
					->select('f_timeout')
					->where('id','=',$ifsched)
					->lists('f_timeout');
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Friday')
					->get();
					$ifreqbreak = DB::table('schedules')
					->select('require_break_punches')
					->where('id','=',$ifsched)
					->get();
					
					
					}
					if($day_name == 'Saturday')
					{	
					$schedto = DB::table('schedules')
					->select('sat_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Saturday')
					->get();
					}
					if($day_name == 'Sunday')
					{	
					$schedto = DB::table('schedules')
					->select('sun_timeout')
					->where('id','=',$ifsched)
					->get();
					$break= DB::table('schedules')
					->join('breaks','schedules.id','=','breaks.schedule_id')
					->select('breaks.break_in','breaks.break_out')
					->where('day','=','Sunday')
					->get();
					}
				
				}
				$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
				$punchin = DB::table('punchstatus')
				->select('time_in_punch_id')
				->where('employee_id','=',$employs->id)
				->whereBetween('punchstatus.date', array($datefrom, $dateto))
				->lists('time_in_punch_id');

				$punchout =DB::table('punchstatus')
				->select('time_out_punch_id')
				->where('employee_id','=',$employs->id)
				->whereBetween('punchstatus.date', array($datefrom, $dateto))
				->lists('time_out_punch_id');

				$breakin =DB::table('punchstatus')
				->select('break_in_punch_id')
				->whereBetween('punchstatus.date', array($datefrom, $dateto))
				->where('employee_id','=',$employs->id)
				->lists('break_in_punch_id');

				$breakout =DB::table('punchstatus')
				->select('break_out_punch_id')
				->whereBetween('punchstatus.date', array($datefrom, $dateto))
				->where('employee_id','=',$employs->id)
				->lists('break_out_punch_id');
				if($punchin != null && $punchout != null)
				{
					$timein = DB::table('punches')
					->whereIn('id',$punchin)
					->get();
				
					$timeout = DB::table('punches')
					->whereIn('id',$punchout)
					->get();
					$inbreak = DB::table('punches')
					->select('time')
					->where('id','=',$breakin)
					->get();

					$outbreak = DB::table('punches')
					->select('time')
					->where('id','=',$breakout)
					->get();

					foreach($timeout as $time_out)
					{
						foreach($timein as $time_in)
						{
							foreach($schedto as $sched)
							{
								$timeout = $time_out->time +12;
								if($timeout > $sched)
								{
									$breakminutes = 0;
									foreach($break as $breaks)
						   			{
						   				if($ifreqbreak == 'No')
						   				{
						   				
											//split break in in hours and minutes
											$separatedData = explode(':', $breaks->break_in);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakinMinutes = $minutesInHours + $minutesInDecimals;

											$separatedData = explode(':', $breaks->break_out);
											$minutesInHours    = $separatedData[0] * 60;
											$minutesInDecimals = $separatedData[1];
											$breakoutMinutes = $minutesInHours + $minutesInDecimals;
											$breakminutes = $breakoutMinutes - $breakinMinutes;
						   				}
						   				else
						   				{

						   					if($inbreak != null && $outbreak != null)
						   					{ 
						   						foreach($inbreak as $inbreaks)
						   						{
						   							$separatedData = explode(':', $inbreaks->time);
													$minutesInHours    = $separatedData[0] * 60;
													$minutesInDecimals = $separatedData[1];
													$breakinMinutes = $minutesInHours + $minutesInDecimals;
												}
											
												foreach($outbreak as $outbreaks)
						   						{
													$separatedData = explode(':', $outbreaks->time);
													$minutesInHours    = ($separatedData[0] +12) * 60;
													$minutesInDecimals = $separatedData[1];
													$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												
												}
											
												$breakminutes = $breakoutMinutes - $breakinMinutes;

											}
											else
											{
												$separatedData = explode(':', $breaks->break_in);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakinMinutes = $minutesInHours + $minutesInDecimals;

												$separatedData = explode(':', $breaks->break_out);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												$breakminutes = $breakoutMinutes - $breakinMinutes;
											}
						   				}
									}
									if($ifot != null)
									{

										foreach($allowedothr as $hr)
										{
											foreach($schedto as $schedout)
											{
												$allowed = $hr->Allowed_number_of_hours*60;
												$activeafter = $hr->active_after*60;
												$separatedData = explode(':', $schedout);
												$minutesInHours    = ($separatedData[0]) * 60;
												$minutesInDecimals = $separatedData[1];
												$totalMinutes1 = $minutesInHours + $minutesInDecimals;
												$span = ($totalMinutes1 + $allowed) + $activeafter;
												//$span = ($schedout + $hr->Allowed_number_of_hours) + $hr->active_after;
												$hours = floor($span / 60);
												$decimalMinutes = $span - floor($span/60) * 60;
												$spanhr = sprintf("%d:%02.0f", $hours, $decimalMinutes);
												//$span = ($schedout->m_timeout + $hr->Allowed_number_of_hours) + $hr->active_after;
												if($timeout > $spanhr)
												{
													$overtimemin = ($span - $totalMinutes1) - $activeafter;
													$hours = floor($overtimemin / 60);
													$decimalMinutes = $overtimemin - floor($overtimemin/60) * 60;
				
													$overtimeMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
													//$overtime = ($span - $schedout->m_timeout) - $hr->active_after;
												}
												else
												{	
													$separatedData = explode(':', $time_out->time);
													$minutesInHours    = ($separatedData[0] +12	) * 60;
													$minutesInDecimals = $separatedData[1];
													$totalMinutes2 = $minutesInHours + $minutesInDecimals;
												
													$separatedData = explode(':', $schedout);
													$minutesInHours    = ($separatedData[0]) * 60;
													$minutesInDecimals = $separatedData[1];
													$totalMinutes1 = $minutesInHours + $minutesInDecimals;
											
													$activeafter = $hr->active_after*60;
													$overtimemin = ($totalMinutes2 - $totalMinutes1) - $activeafter;

													$hours = floor($overtimemin / 60);
													$decimalMinutes = $overtimemin - floor($overtimemin/60) * 60;
												
													$overtimeMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
													
													//$overtime = ($time_out->time - $schedout->m_timeout) - $hr->active_after;
												}
												$separatedData = explode(':', $sched);

												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];

												$totalMinutes = $minutesInHours + $minutesInDecimals;
									
											// Split time out in hours and minutes.
												$separatedData = explode(':', $time_in->time);

												$minutesInHours    = ($separatedData[0] +12	) * 60;
												$minutesInDecimals = $separatedData[1];
		
												$totalMinutes2 = $minutesInHours + $minutesInDecimals;
									
											//convert minutes to hours:minutes
												$mulated = $totalMinutes - $totalMinutes2;
											
												$mulated = $mulated + 720;
												$mulated = $mulated - $breakminutes;
												$hours = floor($mulated / 60);
												$decimalMinutes = $mulated - floor($mulated/60) * 60;
				
												$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);

												$acchrs = $hoursMinutes;
												$total = $mulated + $overtimemin;
												$hours = floor($total / 60);
												$decimalMinutes = $total - floor($total/60) * 60;
											
												$totalMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
												$total = $totalMinutes;
												//$acchrs = $schedout->m_timeout - $time_in->time;
												//if($acchrs < 0 )
												//{
												//	$acchrs = $acchrs + 12;
												//}
												//$total = $total + $acchrs + $overtime;
											} 
										}
									}
									else
									{
										$separatedData = explode(':', $sched);


										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];

										$totalMinutes = $minutesInHours + $minutesInDecimals;
									
										// Split time out in hours and minutes.
										$separatedData = explode(':', $time_in->time);

										$minutesInHours    = ($separatedData[0] +12	) * 60;
										$minutesInDecimals = $separatedData[1];

										$totalMinutes2 = $minutesInHours + $minutesInDecimals;
									
									//convert minutes to hours:minutes
										$mulated = $totalMinutes - $totalMinutes2;
									
										$mulated = $mulated + 720;
										$mulated = $mulated - $breakminutes;
										$hours = floor($mulated / 60);
										$decimalMinutes = $mulated - floor($mulated/60) * 60;
				
										$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);

										$acchrs = $hoursMinutes;
										$total = $hoursMinutes;
										//foreach($schedto as $schedout)
										//{
										//$acchrs = $schedout->m_timeout - $time_in->time;
										//if($acchrs < 0 )
										//{
										//	$acchrs = $acchrs + 12;
							
										//}
										//$total = $total + $acchrs + $overtime;
										//}
									}
							
								}
								else
								{
									$breakminutes = 0;
									foreach($break as $breaks)
						   			{
						   				if($ifreqbreak == 'No')
						   				{
						   				
									//split break in in hours and minutes
										$separatedData = explode(':', $breaks->break_in);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakinMinutes = $minutesInHours + $minutesInDecimals;

										$separatedData = explode(':', $breaks->break_out);
										$minutesInHours    = $separatedData[0] * 60;
										$minutesInDecimals = $separatedData[1];
										$breakoutMinutes = $minutesInHours + $minutesInDecimals;
										$breakminutes = $breakoutMinutes - $breakinMinutes;
						   				}
						   				else
						   				{

						   					if($inbreak != null && $outbreak != null)
						   					{ 
						   						foreach($inbreak as $inbreaks)
						   						{
						   							$separatedData = explode(':', $inbreaks->time);
													$minutesInHours    = $separatedData[0] * 60;
													$minutesInDecimals = $separatedData[1];
													$breakinMinutes = $minutesInHours + $minutesInDecimals;
												}
											
												foreach($outbreak as $outbreaks)
						   						{
													$separatedData = explode(':', $outbreaks->time);
													$minutesInHours    = ($separatedData[0] +12) * 60;
													$minutesInDecimals = $separatedData[1];
													$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												
												}
											
												$breakminutes = $breakoutMinutes - $breakinMinutes;

											}
											else
											{
												$separatedData = explode(':', $breaks->break_in);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakinMinutes = $minutesInHours + $minutesInDecimals;

												$separatedData = explode(':', $breaks->break_out);
												$minutesInHours    = $separatedData[0] * 60;
												$minutesInDecimals = $separatedData[1];
												$breakoutMinutes = $minutesInHours + $minutesInDecimals;
												$breakminutes = $breakoutMinutes - $breakinMinutes;

											}
						   				}
						   	
									}	
									$separatedData = explode(':', $time_in->time);
									$minutesInHours    = $separatedData[0] * 60;
									$minutesInDecimals = $separatedData[1];
									$totalMinutes = $minutesInHours + $minutesInDecimals;

							// Split time out in hours and minutes.
									$separatedData = explode(':', $time_out->time);
									$minutesInHours    = $separatedData[0] * 60;
									$minutesInDecimals = $separatedData[1];
									$totalMinutes2 = $minutesInHours + $minutesInDecimals;
							
							//convert minutes to hours:minutes
									$mulated = $totalMinutes2 - $totalMinutes;
									$mulated = ($mulated + 720)-$breakminutes;
									$overtimemin = 0;

									//$acchrs = $time_out->time - $time_in->time;
									//if($acchrs < 0 )
									//{
									//	$acchrs = $acchrs + 12;
									//}
								
								}
							}
							
						}
						$othrs = $othrs + $overtimemin;
						$hrs = $hrs + $mulated;
						$totalminutes = $totalminutes + $mulated + $overtimemin;

						$hours = floor($totalminutes / 60);
						$decimalMinutes = $totalminutes - floor($totalminutes/60) * 60;
						$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
						$total = $hoursMinutes;	
						//$othrs = $othrs + $overtime;
						//$hrs = $hrs + $acchrs;
						//$total = $total + $acchrs + $overtime ;
					}
					//$acchrs = $hrs;
					//$overtime = $othrs;
					$hours = floor($hrs / 60);
					$decimalMinutes = $hrs - floor($hrs/60) * 60;
					$acchrsMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
					$acchrs = $acchrsMinutes;
				
					$hours = floor($othrs / 60);
					$decimalMinutes = $othrs - floor($othrs/60) * 60;
					$otMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
					$overtime = $otMinutes;
				}
				else
				{
					$acchrs= 0;
					$overtime = 0;
					$total = 0;
				}
				$employers = array('id' => $employs->lname, 'name'=> $employs->fname,'total' => $total, 'acchrs' => $acchrs,'overtime' =>$overtime);
				array_push($employee_lists, $employers);
			}
			
			return View::make('accmltddhrssubodinates')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('supervisor', $supervisor)
				->with('now',$now)
				->with('level', $level)
				->with('hierarchies',$hierarchies)
				->with('subordinates',$subordinates)
				->with('total',$total)
				->with('overtime',$overtime)
				->with('acchrs',$acchrs)
				->with('employee_lists',$employee_lists)
				->with('to',$to)
				->with('user',$user)
				->with('dateto',$dateto);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}
	//show accumulated hours(subordinates)(post)
	public function showPunctualityAssessment()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$dateto = "";
			$to = "";
			$datenow = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $datenow->format('Y-m-d');
			$ontime=DB::table('punchstatus')
			->select('time_in')
			->where('date','=',$now)
			->where('time_in','=','On-Time')
			->where('employee_id','=',$id)
			->count();
			$late=DB::table('punchstatus')
			->select('time_in')
			->where('date','=',$now)
			->where('time_in','=','Late')
			->where('employee_id','=',$id)
			->count();
			$earlyout = DB::table('punchstatus')
			->select('time_out')
			->where('date','=',$now)
			->where('time_out','=','Early out')
			->where('employee_id','=',$id)
			->count();
			$absent=DB::table('punchstatus')
			->select('time_in')
			->where('date','=',$now)
			->where('time_in','=','Absent')
			->where('employee_id','=',$id)
			->count();
			$earlybreak = DB::table('punchstatus')
			->select('break_in')
			->where('date','=',$now)
			->where('break_in','=','Early break')
			->where('employee_id','=',$id)
			->count();
			$longbreak = DB::table('punchstatus')
			->select('break_out')
			->where('date','=',$now)
			->where('break_out','=','Long break')
			->where('employee_id','=',$id)
			->count();
			return View::make('punctassessment')
				->with('id', $id)
				->with('ontime',$ontime)
				->with('late',$late)
				->with('absent',$absent)
				->with('earlybreak',$earlybreak)
				->with('longbreak',$longbreak)
				->with('earlyout',$earlyout)
				->with('name', $name)
				->with('email', $email)
				->with('supervisor', $supervisor)
				->with('now',$now)
				->with('to',$to)
				->with('dateto',$dateto)
				->with('level', $level);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}
	//show punctuality assessment

	public function postshowPunctualityAssessment()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$datenow = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = Input::get('datefrom');
			$to = "to";
			$datefrom = Input::get('datefrom');
			$dateto = Input::get('dateto');
			$ontime=DB::table('punchstatus')
			->select('time_in')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('time_in','=','On-Time')
			->where('employee_id','=',$id)
			->count();
			$late=DB::table('punchstatus')
			->select('time_in')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('time_in','=','Late')
			->where('employee_id','=',$id)
			->count();
			$earlyout = DB::table('punchstatus')
			->select('time_out')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('time_out','=','Early out')
			->where('employee_id','=',$id)
			->count();
			$absent=DB::table('punchstatus')
			->select('time_in')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('time_in','=','Absent')
			->where('employee_id','=',$id)
			->count();
			$earlybreak = DB::table('punchstatus')
			->select('break_in')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('break_in','=','Early break')
			->where('employee_id','=',$id)
			->count();
			$longbreak = DB::table('punchstatus')
			->select('break_out')
			->whereBetween('punchstatus.date', array($datefrom , $dateto))
			->where('break_out','=','Long break')
			->where('employee_id','=',$id)
			->count();
			return View::make('punctassessment')
				->with('id', $id)
				->with('ontime',$ontime)
				->with('late',$late)
				->with('absent',$absent)
				->with('earlybreak',$earlybreak)
				->with('longbreak',$longbreak)
				->with('earlyout',$earlyout)
				->with('name', $name)
				->with('email', $email)
				->with('supervisor', $supervisor)
				->with('now',$now)
				->with('dateto',$dateto)
				->with('to',$to)
				->with('level', $level);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}

	}
	//show punctuality assessment (post)
	public function showPunctualitySub()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$hierarchies = DB::table('hierarchies')
			->select('id')
			->where('supervisor_id','=',$id)
			->lists('id');
			$subordinates = DB::table('hierarchy_subordinates')
			->select('employee_id')
			->whereIn('hierarchy_id',$hierarchies)
			->lists('employee_id');
			$user = DB::table('employs')
			->whereIn('id',$subordinates)
			->get();
			$to = "";
			$employers=array();
			$employee_lists = array();
			$dateto = "";
			$datenow = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $datenow->format('Y-m-d');

			foreach($user as $employs)
			{	
				$ontime=DB::table('punchstatus')
				->select('time_in')
				->where('date','=',$now)
				->where('time_in','=','On-Time')
				->where('employee_id','=',$employs->id)
				->count();
				$late=DB::table('punchstatus')
				->select('time_in')
				->where('date','=',$now)
				->where('time_in','=','Late')
				->where('employee_id','=',$employs->id)
				->count();
				$earlyout = DB::table('punchstatus')
				->select('time_out')
				->where('date','=',$now)
				->where('time_out','=','Early out')
				->where('employee_id','=',$employs->id)
				->count();
				$absent=DB::table('punchstatus')
				->select('time_in')
				->where('date','=',$now)
				->where('time_in','=','Absent')
				->where('employee_id','=',$employs->id)
				->count();
				$earlybreak = DB::table('punchstatus')
				->select('break_in')
				->where('date','=',$now)
				->where('break_in','=','Early break')
				->where('employee_id','=',$employs->id)
				->count();
				$longbreak = DB::table('punchstatus')
				->select('break_out')
				->where('date','=',$now)
				->where('break_out','=','Long break')
				->where('employee_id','=',$employs->id)
				->count();
				$employers = array('id' => $employs->lname, 'name'=>$employs->fname,'earlybreak' => $earlybreak, 'ontime' => $ontime,
								   'longbreak' => $longbreak,'late' => $late,'earlyout' => $earlyout,'absent' =>$absent);
				array_push($employee_lists, $employers);
			}
			return View::make('punctassessmentsub')
				->with('id', $id)
				->with('ontime',$ontime)
				->with('late',$late)
				->with('absent',$absent)
				->with('to',$to)
				->with('earlybreak',$earlybreak)
				->with('longbreak',$longbreak)
				->with('earlyout',$earlyout)
				->with('name', $name)
				->with('email', $email)
				->with('supervisor', $supervisor)
				->with('now',$now)
				->with('employee_lists',$employee_lists)
				->with('dateto',$dateto)
				->with('user',$user)
				->with('level', $level);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}

	}
	//show punctuality assessment (subordinates)
	public function postshowPunctualitySub()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$datefrom = Input::get('datefrom');
			$now = Input::get('datefrom');
			$to = "to";
			$dateto = Input::get('dateto');
			$hierarchies = DB::table('hierarchies')
			->select('id')
			->where('supervisor_id','=',$id)
			->lists('id');
			$subordinates = DB::table('hierarchy_subordinates')
			->select('employee_id')
			->whereIn('hierarchy_id',$hierarchies)
			->lists('employee_id');
			$user = DB::table('employs')
			->whereIn('id',$subordinates)
			->get();
			$employers=array();
			$employee_lists = array();
	

			foreach($user as $employs)
			{	
				$ontime=DB::table('punchstatus')
				->select('time_in')
				->whereBetween('punchstatus.date', array($datefrom , $dateto))
				->where('time_in','=','On-Time')
				->where('employee_id','=',$employs->id)
				->count();
				$late=DB::table('punchstatus')
				->select('time_in')
				->whereBetween('punchstatus.date', array($datefrom , $dateto))
				->where('time_in','=','Late')
				->where('employee_id','=',$employs->id)
				->count();
				$earlyout = DB::table('punchstatus')
				->select('time_out')
				->whereBetween('punchstatus.date', array($datefrom , $dateto))
				->where('time_out','=','Early out')
				->where('employee_id','=',$employs->id)
				->count();
				$absent=DB::table('punchstatus')
				->select('time_in')
				->whereBetween('punchstatus.date', array($datefrom , $dateto))
				->where('time_in','=','Absent')
				->where('employee_id','=',$employs->id)
				->count();
				$earlybreak = DB::table('punchstatus')
				->select('break_in')
				->whereBetween('punchstatus.date', array($datefrom , $dateto))
				->where('break_in','=','Early break')
				->where('employee_id','=',$employs->id)
				->count();
				$longbreak = DB::table('punchstatus')
				->select('break_out')
				->whereBetween('punchstatus.date', array($datefrom , $dateto))
				->where('break_out','=','Long break')
				->where('employee_id','=',$employs->id)
				->count();
				$employers = array('id' => $employs->lname,  'name'=>$employs->fname,'earlybreak' => $earlybreak, 'ontime' => $ontime,
								   'longbreak' => $longbreak,'late' => $late,'earlyout' => $earlyout,'absent' =>$absent);
				array_push($employee_lists, $employers);
			}
			return View::make('punctassessmentsub')
				->with('id', $id)
				->with('ontime',$ontime)
				->with('late',$late)
				->with('absent',$absent)
				->with('earlybreak',$earlybreak)
				->with('longbreak',$longbreak)
				->with('earlyout',$earlyout)
				->with('name', $name)
				->with('email', $email)
				->with('supervisor', $supervisor)
				->with('now',$now)
				->with('employee_lists',$employee_lists)
				->with('dateto',$dateto)
				->with('to',$to)
				->with('user',$user)
				->with('level', $level);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}

	}
	//show punctuality asssessment (subordinates)(post)
	public function showDTR()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$month = Input::get('month');
			$get_year = Input::get('year');
			$employees = DB::table('employs')->where('level_id', '=', '0')->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$requests = DB::table('create_requests')->get();
			Session::put('month_query', $month);
			Session::put('year_query', $get_year);

			$employee = DB::table('employs')->where('id', '=', $id)->get();
			foreach ($employee as $emp)
			{
				$fname = $emp->fname;
				$lname = $emp->lname;
			}

			Session::put('emp_lname', $lname);
			Session::put('emp_fname', $fname);
			
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$ts = strtotime($now);
			$year = date('Y', $ts);
			$is_post = 'true';
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
				->lists('full_name', 'id');
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
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$sub_id = Input::get('employs_id');
			$id = Session::get('empid', '1');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$lname = '';
			$fname = '';
			$month = Input::get('month');
			$get_year = Input::get('year');
			$employees = DB::table('employs')->where('level_id', '=', '0')->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$requests = DB::table('create_requests')->get();
			Session::put('subid', $sub_id);
			Session::put('month_query', $month);
			Session::put('year_query', $get_year);

			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$currentid = Session::get('empid', '1');
			$hierarchies = DB::table('hierarchies')
				->select('id')
				->where('supervisor_id','=',$currentid)
				->lists('id');
			$subordinates = DB::table('hierarchy_subordinates')
				->select('employee_id')
				->whereIn('hierarchy_id',$hierarchies)
				->lists('employee_id');
			$user = DB::table('employs')
				->select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
				->whereIn('id',$subordinates)
				->lists('full_name', 'id');

			$employee = DB::table('employs')->where('id', '=', $sub_id)->get();
			foreach ($employee as $emp)
			{
				$fname = $emp->fname;
				$lname = $emp->lname;
			}

			Session::put('sub_emp_lname', $lname);
			Session::put('sub_emp_fname', $fname);
			
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$ts = strtotime($now);
			$year = date('Y', $ts);
			$is_post = 'true';
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
				->lists('full_name', 'id');
			return View::make('dtrsubordinates')
				->with('hierarchies',$hierarchies)
				->with('subordinates',$subordinates)
				->with('user',$user)
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
	public function showPunctualityPdfAssessment()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$emp_id = Session::get('empid', 'default');
			$month = Input::get('month');
			$get_year = Input::get('year');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$lname = '';
			$fname = '';
			Session::put('emp_query', $emp_id);
			Session::put('month_query', $month);
			Session::put('year_query', $get_year);

			$employee = DB::table('employs')->where('id', '=', $emp_id)->get();
			foreach ($employee as $emp)
			{
				$fname = $emp->fname;
				$lname = $emp->lname;
			}

			Session::put('emp_lname', $lname);
			Session::put('emp_fname', $fname);
			
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$ts = strtotime($now);
			$year = date('Y', $ts);
			$is_post = 'true';
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
				->lists('full_name', 'id');
			return View::make('emp_assessment_report')
				->with('id', $emp_id)
				->with('employs_id',$employs_id)
				->with('emp_id', $emp_id)
				->with('year',$year)
				->with('name', $name)
				->with('email', $email)
				->with('supervisor', $supervisor)
				->with('level', $level)
				->with('is_post', $is_post);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	public function showPunctualityPDFSub()
	{

		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$sub_id = Input::get('employs_id');
			$id = Session::get('empid', '1');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$lname = '';
			$fname = '';
			$month = Input::get('month');
			$get_year = Input::get('year');
			$employees = DB::table('employs')->where('level_id', '=', '0')->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$requests = DB::table('create_requests')->get();
			Session::put('subid', $sub_id);
			Session::put('month_query', $month);
			Session::put('year_query', $get_year);

			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$currentid = Session::get('empid', '1');
			$hierarchies = DB::table('hierarchies')
				->select('id')
				->where('supervisor_id','=',$currentid)
				->lists('id');
			$subordinates = DB::table('hierarchy_subordinates')
				->select('employee_id')
				->whereIn('hierarchy_id',$hierarchies)
				->lists('employee_id');
			$user = DB::table('employs')
				->select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
				->whereIn('id',$subordinates)
				->lists('full_name', 'id');

			$employee = DB::table('employs')->where('id', '=', $sub_id)->get();
			foreach ($employee as $emp)
			{
				$fname = $emp->fname;
				$lname = $emp->lname;
			}

			Session::put('sub_emp_lname', $lname);
			Session::put('sub_emp_fname', $fname);
			
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$ts = strtotime($now);
			$year = date('Y', $ts);
			$is_post = 'true';
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
				->lists('full_name', 'id');
			return View::make('sub_assessment_report')
				->with('hierarchies',$hierarchies)
				->with('subordinates',$subordinates)
				->with('user',$user)
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

	public function showAccumulatedPDFSub()
	{

		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$sub_id = Input::get('employs_id');
			$id = Session::get('empid', '1');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$lname = '';
			$fname = '';
			$month = Input::get('month');
			$get_year = Input::get('year');
			$employees = DB::table('employs')->where('level_id', '=', '0')->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$requests = DB::table('create_requests')->get();
			Session::put('subid', $sub_id);
			Session::put('month_query', $month);
			Session::put('year_query', $get_year);

			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$currentid = Session::get('empid', '1');
			$hierarchies = DB::table('hierarchies')
				->select('id')
				->where('supervisor_id','=',$currentid)
				->lists('id');
			$subordinates = DB::table('hierarchy_subordinates')
				->select('employee_id')
				->whereIn('hierarchy_id',$hierarchies)
				->lists('employee_id');
			$user = DB::table('employs')
				->select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
				->whereIn('id',$subordinates)
				->lists('full_name', 'id');

			$employee = DB::table('employs')->where('id', '=', $sub_id)->get();
			foreach ($employee as $emp)
			{
				$fname = $emp->fname;
				$lname = $emp->lname;
			}

			Session::put('sub_emp_lname', $lname);
			Session::put('sub_emp_fname', $fname);
			
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$ts = strtotime($now);
			$year = date('Y', $ts);
			$is_post = 'true';
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
				->lists('full_name', 'id');
			return View::make('accumulated_subordinates')
				->with('hierarchies',$hierarchies)
				->with('subordinates',$subordinates)
				->with('user',$user)
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

	public function showAccumulatedPDF()
	{

		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			//$sub_id = Input::get('employs_id');
			$id = Session::get('empid', '1');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$lname = '';
			$fname = '';
			$month = Input::get('month');
			$get_year = Input::get('year');
			$employees = DB::table('employs')->where('level_id', '=', '0')->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$requests = DB::table('create_requests')->get();
			//Session::put('subid', $sub_id);
			Session::put('month_query', $month);
			Session::put('year_query', $get_year);

			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$currentid = Session::get('empid', '1');

			$employee = DB::table('employs')->where('id', '=', $id)->get();
			foreach ($employee as $emp)
			{
				$fname = $emp->fname;
				$lname = $emp->lname;
			}

			Session::put('emp_lname', $lname);
			Session::put('emp_fname', $fname);
			
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$ts = strtotime($now);
			$year = date('Y', $ts);
			$is_post = 'true';
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
				->lists('full_name', 'id');
			return View::make('accumulated_emp')
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
}
?>