<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/ 

	 public function showWelcome()
	{
		return View::make('homepage');
	}

	public function showAbsent()
	{
		$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
		$absents = DB::table('punchstatus')->join('employs','punchstatus.employee_id' , '=', 'employs.id')
		->where('punchstatus.date', '=', $now)->where('time_in', '=', 'Absent')->get();
		$departments = DB::table('departments')->get();
		return View::make('absent_employee')
			->with('absents', $absents)
			->with('departments', $departments);
		
	}

	public function showManual()
	{
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$ts=strtotime($now);
			$year = date('Y', $ts);
			$is_post = 'false';
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->lists('full_name', 'id');
		return View::make('dtr_report')
			->with('employs_id', $employs_id)
			->with('year', $year)
			->with('is_post', $is_post);
		
	}

	public function postManual()
	{		$dtr_date = Input::get('dtr_date');
			$emp_id = Input::get('employs_id');
			$month = Input::get('month');
			$get_year = Input::get('year');
			$punch_in = DB::table('punchstatus')
			->join('punches', 'time_in_punch_id', '=', 'punches.id')
			->where('punchstatus.employee_id', '=', $emp_id)
			->where( DB::raw('MONTH(punchstatus.date)'), '=', $month)
			->where( DB::raw('YEAR(punchstatus.date)'), '=', $get_year)
			->orderby('punchstatus.date')
			->get();
			$punch_out = DB::table('punchstatus')
			->join('punches', 'time_out_punch_id', '=', 'punches.id')
			->where('punchstatus.employee_id', '=', $emp_id)
			->where( DB::raw('MONTH(punchstatus.date)'), '=', $month)
			->where( DB::raw('YEAR(punchstatus.date)'), '=', $get_year)
			->orderby('punchstatus.date')
			->get();
			$punch_day = DB::table('punchstatus')->select(DB::raw('DAY(date) as day, id'))
			->where('punchstatus.employee_id', '=', $emp_id)
			->where( DB::raw('MONTH(punchstatus.date)'), '=', $month)
			->where( DB::raw('YEAR(punchstatus.date)'), '=', $get_year)
			->orderby('punchstatus.date')
			->lists('day', 'id');
			$month_name = date("F", mktime(0, 0, 0, $month, 10));
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$ts=strtotime($now);
			$year = date('Y', $ts);
			$is_post = 'true';
			$employee = DB::table('employs')->where('id', '=', $emp_id)->get();
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->lists('full_name', 'id');
			return View::make('dtr_report')
			->with('employs_id', $employs_id)
			->with('year', $year)
			->with('is_post', $is_post)
			->with('punch_in', $punch_in)
			->with('punch_out', $punch_out)
			->with('punch_day', $punch_day)
			->with('employee', $employee)
			->with('emp_id', $emp_id)
			->with('get_year', $get_year)
			->with('month_name', $month_name)
			->with('dtr_date', $dtr_date);	
	}
	public function postManualAdjust()
	{		
			$emp_id = Input::get('emp_id');
			$month = Input::get('month');
			$get_year = Input::get('year');
			$dtr_date = Input::get('dtr_date');
			$time_in = Input::get('time_in');
			$time_out = Input::get('time_out');
			$punch_date = DB::table('punchstatus')
			->where('employee_id', '=', $emp_id)
			->where('date', '=', $dtr_date)->get();
			
			if($punch_date == null and $time_in != null and $time_out != null)
			{
				DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
				 array($dtr_date, $time_in, $emp_id) );
				$t_in = DB::table('punches')->max('id');
				DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
				 array($dtr_date, $time_out, $emp_id) );
				$t_out = DB::table('punches')->max('id');
				DB::statement('INSERT INTO punchstatus (time_in, time_in_punch_id, break_in, break_in_punch_id, 
					break_out, break_out_punch_id, time_out, time_out_punch_id, date, employee_id)
					 values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
				 array('On-time', $t_in, null, null, null, null, 'On-time', $t_out, $dtr_date, $emp_id) );
			}
			if($punch_date != null and $time_in != null and $time_out != null)
			{		
				foreach($punch_date as $pd){
					DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
				 		array('sur' => $time_in, 'res2' => $pd->time_in_punch_id) );
					DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
				 		array('sur' => $time_out, 'res2' => $pd->time_out_punch_id) );
				}
			}
			$punch_in = DB::table('punchstatus')
			->join('punches', 'time_in_punch_id', '=', 'punches.id')
			->where('punchstatus.employee_id', '=', $emp_id)
			->where( DB::raw('MONTH(punchstatus.date)'), '=', $month)
			->where( DB::raw('YEAR(punchstatus.date)'), '=', $get_year)
			->orderby('punchstatus.date')
			->get();
			$punch_out = DB::table('punchstatus')
			->join('punches', 'time_out_punch_id', '=', 'punches.id')
			->where('punchstatus.employee_id', '=', $emp_id)
			->where( DB::raw('MONTH(punchstatus.date)'), '=', $month)
			->where( DB::raw('YEAR(punchstatus.date)'), '=', $get_year)
			->orderby('punchstatus.date')
			->get();
			$punch_day = DB::table('punchstatus')->select(DB::raw('DAY(date) as day, id'))
			->where('punchstatus.employee_id', '=', $emp_id)
			->where( DB::raw('MONTH(punchstatus.date)'), '=', $month)
			->where( DB::raw('YEAR(punchstatus.date)'), '=', $get_year)
			->orderby('punchstatus.date')
			->lists('day', 'id');
			$month_name = date("F", mktime(0, 0, 0, $month, 10));
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$ts=strtotime($now);
			$year = date('Y', $ts);
			$is_post = 'true';
			$employee = DB::table('employs')->where('id', '=', $emp_id)->get();
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->lists('full_name', 'id');
			return View::make('dtr_report')
			->with('employs_id', $employs_id)
			->with('year', $year)
			->with('is_post', $is_post)
			->with('punch_in', $punch_in)
			->with('punch_out', $punch_out)
			->with('punch_day', $punch_day)
			->with('employee', $employee)
			->with('get_year', $get_year)
			->with('month_name', $month_name)
			->with('emp_id', $emp_id)
			->with('dtr_date', $dtr_date);	
	}
	public function postManualDelete()
	{		
			$emp_id = Input::get('emp_id');
			$month = Input::get('month');
			$get_year = Input::get('year');
			$dtr_date = Input::get('dtr_date');
			$punch_date = DB::table('punchstatus')
			->where('employee_id', '=', $emp_id)
			->where('date', '=', $dtr_date)->get();
			
			if($punch_date != null)
			{
				foreach($punch_date as $pd){
					DB::statement("DELETE FROM punches WHERE id=:sid", array('sid'=>$pd->time_in_punch_id));
					DB::statement("DELETE FROM punches WHERE id=:sid", array('sid'=>$pd->time_out_punch_id));
				}
					DB::statement("DELETE FROM punchstatus WHERE employee_id=:sid AND date=:sdate", array('sid'=>$emp_id, 'sdate'=>$dtr_date));
			}
			$punch_in = DB::table('punchstatus')
			->join('punches', 'time_in_punch_id', '=', 'punches.id')
			->where('punchstatus.employee_id', '=', $emp_id)
			->where( DB::raw('MONTH(punchstatus.date)'), '=', $month)
			->where( DB::raw('YEAR(punchstatus.date)'), '=', $get_year)
			->orderby('punchstatus.date')
			->get();
			$punch_out = DB::table('punchstatus')
			->join('punches', 'time_out_punch_id', '=', 'punches.id')
			->where('punchstatus.employee_id', '=', $emp_id)
			->where( DB::raw('MONTH(punchstatus.date)'), '=', $month)
			->where( DB::raw('YEAR(punchstatus.date)'), '=', $get_year)
			->orderby('punchstatus.date')
			->get();
			$punch_day = DB::table('punchstatus')->select(DB::raw('DAY(date) as day, id'))
			->where('punchstatus.employee_id', '=', $emp_id)
			->where( DB::raw('MONTH(punchstatus.date)'), '=', $month)
			->where( DB::raw('YEAR(punchstatus.date)'), '=', $get_year)
			->orderby('punchstatus.date')
			->lists('day', 'id');
			$month_name = date("F", mktime(0, 0, 0, $month, 10));
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$ts=strtotime($now);
			$year = date('Y', $ts);
			$is_post = 'true';
			$employee = DB::table('employs')->where('id', '=', $emp_id)->get();
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->lists('full_name', 'id');
			return View::make('dtr_report')
			->with('employs_id', $employs_id)
			->with('year', $year)
			->with('is_post', $is_post)
			->with('punch_in', $punch_in)
			->with('punch_out', $punch_out)
			->with('punch_day', $punch_day)
			->with('employee', $employee)
			->with('get_year', $get_year)
			->with('month_name', $month_name)
			->with('emp_id', $emp_id);	
	}

	public function showDashboard()
	{	
		$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
		$now = $date->format('Y-m-d');
		$request= DB::table('create_requests')->where('status', '=', 'approved')->count();
		$punch= DB::table('punchstatus')->where('date', '=', $now)->where('time_in', '=', 'Absent')->count();
		 return View::make('dashboard')
		->with('request', $request)
		->with('punch', $punch)
		;
	}
	public function postLeaveSummary()
	{
		$id = Input::get('id');
		$emp_id = Input::get('emp_id');
		$start_date = Input::get('start_date');
		$end_date = Input::get('end_date');
		$request_type = Input::get('type');
		DB::statement('INSERT INTO leavesummaries (employee_id, start_date, end_date, request_type) values (?, ?, ?, ?)',
				 array($emp_id, $start_date, $end_date, $request_type) );

		$create_requests = DB::table('create_requests')->where('id','=', $id)->where('status', '=', 'approved')->get();
			
			foreach ($create_requests as $create_request) {
			
			DB::statement('UPDATE create_requests SET status=:sur WHERE id=:res2',
				 array('sur' => 'changed', 'res2' => $id) );
		}
		$create_requests= DB::table('create_requests')->join('employs', 'employs.id', '=', 'create_requests.employee_id')->where('create_requests.status', '=', 'approved')->get();
			$i = 0;
			
			   // MySQL datetime format
		if ($create_requests != null)	{
			foreach ($create_requests as $employee) {
			$now = $employee->end_date;
			$hdate = $employee->start_date;
			$ts1=strtotime($hdate);
			$ts2=strtotime($now);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$day1 = date('d', $ts1); /* I'VE ADDED THE DAY VARIABLE OF DATE1 AND DATE2 */
			$day2 = date('d', $ts2);

			$diff[$i] = (($year2 - $year1) * 360) + (($month2 - $month1)*12) + ($day2 - $day1) + 1;
			$i++;
				}
		} else {
			$diff = 0;
		}
		Session::flash('message10', 'Leave successfully executed');
		return View::make('approved_leave')
		->with('create_requests', $create_requests)
		->with('diff', $diff);


	}

	public function showApproved()
	{		
			$create_requests= DB::table('employs')->join('create_requests', 'create_requests.employee_id', '=','employs.id' )->where('create_requests.status', '=', 'approved')->get();
			$i = 0;
					
			   // MySQL datetime format
			if ($create_requests != null)
			{
				foreach ($create_requests as $employee)
				{
					$now = $employee->end_date;
					$hdate = $employee->start_date;
					$ts1=strtotime($hdate);
					$ts2=strtotime($now);

					$year1 = date('Y', $ts1);
					$year2 = date('Y', $ts2);

					$month1 = date('m', $ts1);
					$month2 = date('m', $ts2);

					$day1 = date('d', $ts1); /* I'VE ADDED THE DAY VARIABLE OF DATE1 AND DATE2 */
					$day2 = date('d', $ts2);

					$diff[$i] = (($year2 - $year1) * 360) + (($month2 - $month1)*12) + ($day2 - $day1) + 1;
					$i++;
				}
			} else 
			{
				$diff = 0;
			}


		
		return View::make('approved_leave')
		->with('create_requests', $create_requests)
		->with('diff', $diff);
	
	}
	public function showLogin()
	{
		return View::make('login');
	}

	public function showMaintenance()
	{
		return View::make('maintenance');
	}

	public function showTransaction()
	{
		return View::make('transaction');
	}
	public function showPdfreports()
	{
	
		return View::make('sampol');
		
	}
	public function showPdfreportsbranch()
	{
		return View::make('reportsbybranch');	
	}

	public function showPdfreportsdepartment()
	{
		return View::make('reportsbydepartment');	
	}

	public function showPdfreportshierarchy()
	{
		return View::make('reportsbyhierarchy');	
	}

	public function showQuery()
	{
		return View::make('query');
	}

	public function showQueryEmpbydept()
	{
		$employs = DB::table('employs')->get();
		$departments = ['Select a department...'] + DB::table('departments')
		->lists('name', 'id');
		$departmentss = DB::table('departments')->get();
		return View::make('empbydept')
		->with('employs',$employs)
		->with('departments',$departments)
		->with('departmentss',$departmentss);
	
	}

	public function postshowQueryEmpbydept()
	{
		$id_dropdown = Input::get('departmento');
		$employs = DB::table('employs')->where('department_id', '=', $id_dropdown)->get();
		$departments = ['Select a department...'] + DB::table('departments')
		->lists('name', 'id');
		$departmentss = DB::table('departments')->get();
		return View::make('empbydept')
		->with('id_dropdown', $id_dropdown)
		->with('employs',$employs)
		->with('departments',$departments)
		->with('departmentss',$departmentss);
	}

	public function showQueryEmpbybranch()
	{
		$employs = DB::table('employs')->get();
		$branchess= DB::table('branches')->get();
		$branches = ['Select a branch...'] + DB::table('branches')
		->lists('branch_name', 'id');
		$departments = DB::table('departments')->get();
		return View::make('empbybranch')
		->with('employs',$employs)
		->with('branches',$branches)
		->with('branchess',$branchess)
		->with('departments',$departments);

	}
/*ROCK WELL =====================================================================*/
	
	public function showPdfreportsleave()
	{
		$month = '';
		$year = '';
		return View::make('reportsleave')
		->with('month',$month)
		->with('year',$year);	
	}

	public function postPdfreportsleave()
	{
		$month = Input::get('month');
		$year = Input::get('year');
		Session::put('month_query', $month);
		Session::put('year_query', $year);
		return View::make('showreportleave')
		->with('month',$month)
		->with('year',$year);	
	}

	public function showPdfreportsdtr()
	{
		$emp_id = Input::get('employs_id');
		$month = Input::get('month');
		$get_year = Input::get('year');
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
		return View::make('admindtr')
		->with('employs_id',$employs_id)
		->with('emp_id', $emp_id)
		->with('year',$year)
		->with('is_post', $is_post);	
	}
	
	public function showLeaveCases()
	{
		$status = '';
		$leaves = DB::table('create_requests')->get();
		$employs = DB::table('employs')->get();
		return View::make('leavecases')
		->with('leaves',$leaves)
		->with('employs',$employs)
		->with('status',$status);
	}

	public function postshowLeaveCases()
	{
		$status = Input::get('status');
		$date = Input::get('date');
		$leaves = DB::table('create_requests')
		->where('status','=',$status)
		->orWhere('request_date','=',$date)
		->get();
		$employs = DB::table('employs')->get();
		return View::make('leavecases')
		->with('leaves',$leaves)
		->with('status',$status)
		->with('employs',$employs);
	}
/*ROCK WELL =========================================*/

	public function showLeaveCredit()
	{

		$employs = DB::table('employs')->get();
		$credits = DB::table('leavecredits')->get();
		$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$i = 0;

			// MySQL datetime format
			
			foreach ($employs as $employee) {
			
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

									$sick_leave[$i] = (($totyear *15) + $totmonth * 1.25) - $credit->sick_leave;

									$vacation_leave[$i] = (($totyear *15) + $totmonth * 1.25) - $credit->vacation_leave;						

							}
						}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
								$sick_leave[$i] = (($totyear *15) + $totmonth * 1.25);

								$vacation_leave[$i] = (($totyear *15) + $totmonth * 1.25) ;
								}
							
							if($vacation_leave[$i] >= 10)
							{
								foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){

								$force_counter = 5 * $totyear;
								$force_leave[$i] = 5 - $credit->force_leave;
								$vacation_leave[$i] = (($totyear *15) + $totmonth * 1.25) - $force_counter - $credit->vacation_leave;

								}
							}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$force_counter = 5 * $totyear;
									$force_leave[$i] = 5;
									$vacation_leave[$i] = (($totyear *15) + $totmonth * 1.25) - $force_counter;
								}

							}
							else {
								$force_leave[$i] = 0;
							}
						
					}
						if($diff < 12)
						{
							foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){
								$sick_leave[$i] = ($diff * 1.25) - $credit->sick_leave;
								$vacation_leave[$i] = ($diff * 1.25) - $credit->vacation_leave; }}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$sick_leave[$i] = $diff * 1.25;
									$vacation_leave[$i] = $diff * 1.25;
								}
								if($vacation_leave[$i] >= 10)
							{
								foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){
								$force_leave[$i] = 5 - $credit->force_leave;
								$vacation_leave[$i] = ($diff * 1.25) - $force_leave[$i] - $credit->vacation_leave;}}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$force_leave[$i] = 5 - $credit->force_leave;
									$vacation_leave[$i] = ($diff * 1.25) - $force_leave[$i];
								}
							}
							else {
								$force_leave[$i] = 0;
							}
						}

						
						}
					
					else {
						$sick_leave[$i] = 0;
						$vacation_leave[$i] = 0;
						$force_leave[$i] = 0;
						}
						$i = $i + 1;
					}

			
		
		return View::make('leavecredits')
		->with('employs',$employs)
		->with('sick_leave',$sick_leave)
		->with('vacation_leave',$vacation_leave)
		->with('force_leave',$force_leave);

	}

	public function postshowQueryEmpbybranch()
	{
		$id_dropdown = Input::get('branches');
		$branchess= DB::table('branches')->get();
		$branches = ['Select a branch...'] + DB::table('branches')
		->lists('branch_name', 'id');
		$employs = DB::table('employs')->where('department_id', '=', $id_dropdown)->get();
		$departments = DB::table('departments')->get();
		return View::make('empbybranch')
		->with('id_dropdown',$id_dropdown)
		->with('employs',$employs)
		->with('branches',$branches)
		->with('branchess',$branchess)
		->with('departments',$departments);
	}

	public function LeaveDeduct()
	{
		$leavecredits = DB::table('leavecredits')->get();
		$emp_id = Input::get('emp_id');
	
		foreach ($leavecredits as $leavecredit)
		{
	
		if ($leavecredit->employee_id == $emp_id)
			{
			$employee_id = $emp_id;
			$type = Input::get('type');
			if ($type == 'sick_leave')
				{
				$sick_leave = Input::get('deduction') + $leavecredit->sick_leave;
				$vacation_leave = $leavecredit->vacation_leave;
				$force_leave =  $leavecredit->force_leave;
				}
			if ($type == 'vacation_leave') {
				$sick_leave = $leavecredit->sick_leave;
				$vacation_leave = Input::get('deduction') + $leavecredit->vacation_leave;
				$force_leave =  $leavecredit->force_leave;
				}

			if ($type == 'force_leave') {
				$sick_leave = $leavecredit->sick_leave;
				$vacation_leave = $leavecredit->vacation_leave;
				$force_leave = Input::get('deduction') + $leavecredit->force_leave;
				}

				DB::statement('UPDATE leavecredits SET sick_leave=:leave1 , vacation_leave=:leave2 , force_leave=:leave3   WHERE employee_id=:res2',
				 array('leave1' => $sick_leave, 'leave2' => $vacation_leave, 'leave3' => $force_leave, 'res2' => $emp_id) );			}
		}
		$leavecredits = DB::table('leavecredits')->where('employee_id', '=', $emp_id)->get();
		if ($leavecredits == null)
		{
			$id = DB::table('leavecredits')->max('id');
			$id = $id + 1;
			
			$type = Input::get('type');
			if ($type == 'sick_leave')
				{
				$sick_leave = Input::get('deduction');
				$vacation_leave = '0';
				$force_leave = '0';
				}
			if ($type == 'vacation_leave') {
				$sick_leave = '0';
				$vacation_leave = Input::get('deduction');
				$force_leave = '0';
				}
			DB::statement('INSERT INTO leavecredits (employee_id, sick_leave, vacation_leave, force_leave) values (?, ?, ?, ?)',
				 array($emp_id, $sick_leave, $vacation_leave, $force_leave) );
			}


			$employs = DB::table('employs')->get();
			$credits = DB::table('leavecredits')->get();
			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$i = 0;
		
			
			   // MySQL datetime format
			
			foreach ($employs as $employee) {
			
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

									$sick_leaves[$i] = (($totyear *15) + $totmonth * 1.25) - $credit->sick_leave;

									$vacation_leaves[$i] = (($totyear *15) + $totmonth * 1.25) - $credit->vacation_leave;
								

							}
						}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
								$sick_leaves[$i] = (($totyear *15) + $totmonth * 1.25);

								$vacation_leaves[$i] = (($totyear *15) + $totmonth * 1.25) ;
								}
							
							if($vacation_leaves[$i] >= 10)
							{
								foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){

								$force_counter = 5 * $totyear;
								$force_leaves[$i] = 5 -  $credit->force_leave;
								$vacation_leaves[$i] = (($totyear *15) + $totmonth * 1.25) - $force_counter - $credit->vacation_leave;

								}
							}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$force_counter = 5 * $totyear;
									$force_leaves[$i] = 5 -  $credit->force_leave;
									$vacation_leaves[$i] = (($totyear *15) + $totmonth * 1.25) - $force_counter;
								}

							}
							else {
								$force_leaves[$i] = 0;
							}
						
					}
						if($diff < 12)
						{
							foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){
								$sick_leaves[$i] = ($diff * 1.25) - $credit->sick_leave;
								$vacation_leaves[$i] = ($diff * 1.25) - $credit->vacation_leave; }}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$sick_leaves[$i] = $diff * 1.25;
									$vacation_leaves[$i] = $diff * 1.25;
								}
								if($vacation_leaves[$i] >= 10)
							{
								foreach ($credits as $credit)
							{
								if($employee->id == $credit->employee_id){
								$force_leaves[$i] = 5 -  $credit->force_leave;
								$vacation_leaves[$i] = ($diff * 1.25) - $force_leaves[$i] - $credit->vacation_leave;}}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$force_leaves[$i] = 5 -  $credit->force_leave;
									$vacation_leaves[$i] = ($diff * 1.25) - $force_leave[$i];
								}
							}
							else {
								$force_leaves[$i] = 0;
							}
						}

						
						}
					
					else {
						$sick_leaves[$i] = 0;
						$vacation_leaves[$i] = 0;
						$force_leaves[$i] = 0;
						}
						$i = $i + 1;
					}


			
		
		
			
		Session::flash('message10', 'Leave successfully executed, leave credits deducted from the employee');
		return View::make('leavecredits')
		->with('employs',$employs)
		->with('sick_leave',$sick_leaves)
		->with('vacation_leave',$vacation_leaves)
		->with('force_leave',$force_leaves);



		}
				
				public function Deduct()
	{
		$leavecredits = DB::table('leavecredits')->get();
		$emp_id = Input::get('emp_id');
		$start_date = Input::get('start_date');
		$end_date = Input::get('end_date');
		$request_type = Input::get('type');
		$id = Input::get('id');
		$days = Input::get('days');
		DB::statement('INSERT INTO leavesummaries (employee_id, start_date, end_date, request_type) values (?, ?, ?, ?)',
				 array($emp_id, $start_date, $end_date, $request_type) );
		$create_requests = DB::table('create_requests')->where('id','=', $id)->where('status', '=', 'approved')->get();
		foreach ($create_requests as $create_request) {
			
			DB::statement('UPDATE create_requests SET status=:sur WHERE id=:res2',
				 array('sur' => 'changed', 'res2' => $create_request->id) );
		}
		foreach ($leavecredits as $leavecredit)
		{
	
		if ($leavecredit->employee_id == $emp_id)
			{
			$employee_id = $emp_id;
			$type = Input::get('type');
			if ($type == 'Sick Leave')
				{
				$sick_leave = Input::get('days') + $leavecredit->sick_leave;
				$vacation_leave = $leavecredit->vacation_leave;
				$force_leave = $leavecredit->force_leave;
				}
			if ($type == 'Vacation Leave') {
				$sick_leave = $leavecredit->sick_leave;
				$vacation_leave = Input::get('days') + $leavecredit->vacation_leave;
				$force_leave = $leavecredit->force_leave;
				}
			if ($type == 'Force Leave') {
				$sick_leave = $leavecredit->sick_leave;
				$vacation_leave = $leavecredit->vacation_leave;
				$force_leave = Input::get('days') + $leavecredit->force_leave;
				}
				DB::statement('UPDATE leavecredits SET sick_leave=:leave1 , vacation_leave=:leave2 , force_leave=:leave3   WHERE employee_id=:res2',
				 array('leave1' => $sick_leave, 'leave2' => $vacation_leave, 'leave3' => $force_leave, 'res2' => $emp_id) );			}
		}
		$leavecredits = DB::table('leavecredits')->where('employee_id', '=', $emp_id)->get();
		if ($leavecredits == null)
		{
			$id = DB::table('leavecredits')->max('id');
			$id = $id + 1;
			
			$type = Input::get('type');
			if ($type == 'Sick Leave')
				{
				$sick_leave = Input::get('days');
				$vacation_leave = '0';
				$force_leave = '0';
				}
			if ($type == 'Vacation Leave'){
				$sick_leave = '0';
				$vacation_leave = Input::get('days');
				$force_leave = '0';
					}
			if ($type == 'Force Leave'){
				$sick_leave = '0';
				$vacation_leave = '0';
				$force_leave = Input::get('days');
					}
			if ($type != 'Vacation Leave' && $type != 'Sick Leave' && $type != 'Force Leave'){
				$sick_leave = '0';
				$vacation_leave = '0';
				$force_leave = '0';
					}
				DB::statement('INSERT INTO leavecredits (employee_id, sick_leave, vacation_leave , force_leave) values (?, ?, ?, ?)',
				 array($emp_id, $sick_leave, $vacation_leave , $force_leave) );
			}
			

			$create_requests= DB::table('create_requests')->join('employs', 'employs.id', '=', 'create_requests.employee_id')->where('create_requests.status', '=', 'approved')->get();
			
			$i = 0;
		
			
			   // MySQL datetime format
		if ($create_requests != null)	{
			foreach ($create_requests as $employee) {
			$now = $employee->end_date;
			$hdate = $employee->start_date;
			$ts1=strtotime($hdate);
			$ts2=strtotime($now);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$day1 = date('d', $ts1); /* I'VE ADDED THE DAY VARIABLE OF DATE1 AND DATE2 */
			$day2 = date('d', $ts2);

			$diff[$i] = (($year2 - $year1) * 360) + (($month2 - $month1)*12) + ($day2 - $day1) + 1;
			$i++;
					}
			} else {
				$diff = 0;
			}
		
		Session::flash('message11', 'Leave successfully executed, leave credits deducted from the employee');
		return View::make('approved_leave')
		->with('create_requests', $create_requests)
		->with('diff', $diff);



		}
				
	
	public function showEmpSummary()
	{
		$employs = DB::table('employs')->get();
		$departments = DB::table('departments')->get();
		$branches=DB::table('branches')->get();
		$jobtitles=DB::table('jobtitles')->get();
		$contracts=DB::table('contracts')->get();
		$hierarchies=DB::table('hierarchies')->where('supervisor_id','=','5')->lists('id');
		return View::make('empsummary')
		->with('branches',$branches)
		->with('hierarchies',$hierarchies)
		->with('departments',$departments)
		->with('employs',$employs)
		->with('jobtitles',$jobtitles)
		->with('contracts',$contracts);

	}

	public function showReport()
	{
		return View::make('report');
	}

	public function showUtility()
	{
		return View::make('utility');
	}
	
	public function doLogout()
	{
    	Auth::logout();
    	return Redirect::to('login');
	}

	public function doLogin()
	{
		$rules = array(
			'username'   => 'required', 
			'password'=> 'required|alphaNum|min:4'

			);


		$validator = Validator::make(Input::all(), $rules);

		if($validator -> fails()){

			return Redirect::to('login')
			->withErrors($validator)
			->withInput(Input::except('password')); 
		}
		else
		{
			$userdata = array(
				'username'    => Input::get('username'),
				'password' => Input::get('password')
				);

				if(Auth::attempt($userdata))
				{
					return Redirect::to('dashboard');
				}
				else
				{
					return Redirect::to('login');
				}
			
		}
	}



	

}
