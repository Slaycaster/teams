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

	public function postAbsent()
	{
		$date_from = Input::get('date_from');
		$date_to = Input::get('date_to');
		$absents = DB::table('punchstatus')->join('employs','punchstatus.employee_id' , '=', 'employs.id')
		->whereBetween('punchstatus.date', array($date_from , $date_to))->where('time_in', '=', 'Absent')->get();
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

			$break_in = DB::table('punchstatus')
			->join('punches', 'break_in_punch_id', '=', 'punches.id')
			->where('punchstatus.employee_id', '=', $emp_id)
			->where( DB::raw('MONTH(punchstatus.date)'), '=', $month)
			->where( DB::raw('YEAR(punchstatus.date)'), '=', $get_year)
			->orderby('punchstatus.date')
			->get();

			$break_out = DB::table('punchstatus')
			->join('punches', 'break_out_punch_id', '=', 'punches.id')
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
			$employee = DB::table('employs')->where('id', '=', $emp_id)->get();
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->lists('full_name', 'id');

			$break = DB::table('employs')->join('empschedules', 'employs.id', '=', 'empschedules.employee_id')
			->join('schedules', 'empschedules.schedule_id', '=', 'schedules.id')
			->where('employs.id','=',  $emp_id)
			->where('schedules.require_break_punches', '=', 'Yes')
			->get();

			if($break == null)
			{
				$is_post = 'true';
			}
			else {
				$is_post = 'break';

			}
				
			return View::make('dtr_report')
			->with('employs_id', $employs_id)
			->with('year', $year)
			->with('is_post', $is_post)
			->with('punch_in', $punch_in)
			->with('punch_out', $punch_out)
			->with('break_in', $break_in)
			->with('break_out', $break_out)
			->with('punch_day', $punch_day)
			->with('month', $month) 
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
			$break_in = Input::get('break_in');
			$break_out = Input::get('break_out');
			$punch_in = Input::get('punch_in');
			$punch_out = Input::get('punch_out');
			$punch_date = DB::table('punchstatus')
			->where('employee_id', '=', $emp_id)
			->where('date', '=', $dtr_date)->get();
			
			if($punch_date == null and $time_in != null and $time_out != null and $break_in == null and $break_out == null)
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

			if($punch_date == null and $time_in != null and $time_out != null and $break_in != null and $break_out != null)
			{
				DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
				 array($dtr_date, $time_in, $emp_id) );
				$t_in = DB::table('punches')->max('id');
				DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
				 array($dtr_date, $time_out, $emp_id) );
				$t_out = DB::table('punches')->max('id');
				DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
				 array($dtr_date, $time_in, $emp_id) );
				$b_in = DB::table('punches')->max('id');
				DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
				 array($dtr_date, $time_out, $emp_id) );
				$b_out = DB::table('punches')->max('id');
				DB::statement('INSERT INTO punchstatus (time_in, time_in_punch_id, break_in, break_in_punch_id, 
					break_out, break_out_punch_id, time_out, time_out_punch_id, date, employee_id)
					 values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
				 array('On-time', $t_in, 'On-Time', $b_in, 'On-time', $b_out, 'On-time', $t_out, $dtr_date, $emp_id) );
			}

			if($punch_date != null and $time_in != null and $time_out != null and $break_in == null and $break_out == null)
			{		
				foreach($punch_date as $pd){
					if ($pd->time_in_punch_id != null and $pd->time_out_punch_id != null )
					{
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_in, 'res2' => $pd->time_in_punch_id) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_out, 'res2' => $pd->time_out_punch_id) );
					}
					elseif($pd->time_in_punch_id == null and $pd->time_out_punch_id != null)
					{
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $time_in, $emp_id) );
						$t_in = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, time_in_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $t_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_out, 'res2' => $pd->time_out_punch_id) );

					}
					elseif($pd->time_in_punch_id != null and $pd->time_out_punch_id == null)
					{
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $time_in, $emp_id) );
						$t_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_out=:sur1, time_out_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $t_out, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_in, 'res2' => $pd->time_out_punch_id) );

					}
					elseif($pd->time_in_punch_id == null and $pd->time_out_punch_id == null)
					{
						
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $time_in, $emp_id) );
						$t_in = DB::table('punches')->max('id');
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $time_out, $emp_id) );
						$t_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, time_out=:t1, time_out_punch_id=:sur, time_in_punch_id=:sur2 WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time','t1' => 'On-time', 'sur' => $t_out, 'sur2' => $t_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						

					}

				}
			}

			if($punch_date != null and $time_in != null and $time_out != null and $break_in != null and $break_out != null)
			{		
				foreach($punch_date as $pd){
					if ($pd->time_in_punch_id != null and $pd->time_out_punch_id != null and $pd->break_in_punch_id == null and $pd->break_out_punch_id == null )
					{
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_in, 'res2' => $pd->time_in_punch_id) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_out, 'res2' => $pd->time_out_punch_id) );
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $break_in, $emp_id) );
						$b_in = DB::table('punches')->max('id');
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $break_out, $emp_id) );
						$b_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET break_in=:sur1, break_out=:t1, break_out_punch_id=:sur, break_in_punch_id=:sur2 WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time','t1' => 'On-time', 'sur' => $b_out, 'sur2' => $b_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
					}

					if ($pd->time_in_punch_id != null and $pd->time_out_punch_id != null and $pd->break_in_punch_id != null and $pd->break_out_punch_id != null )
					{
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_in, 'res2' => $pd->time_in_punch_id) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_out, 'res2' => $pd->time_out_punch_id) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_in, 'res2' => $pd->break_in_punch_id) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_out, 'res2' => $pd->break_out_punch_id) );
					}

					if ($pd->time_in_punch_id != null and $pd->time_out_punch_id != null and $pd->break_in_punch_id == null and $pd->break_out_punch_id != null )
					{
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_in, 'res2' => $pd->time_in_punch_id) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_out, 'res2' => $pd->time_out_punch_id) );
						
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $break_in, $emp_id) );
								$b_in = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, break_in_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $b_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_out, 'res2' => $pd->break_out_punch_id) );
					}

					if ($pd->time_in_punch_id != null and $pd->time_out_punch_id != null and $pd->break_in_punch_id != null and $pd->break_out_punch_id == null )
					{
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_in, 'res2' => $pd->time_in_punch_id) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_out, 'res2' => $pd->time_out_punch_id) );
						
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $break_out, $emp_id) );
								$b_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, break_out_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $b_out, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_in, 'res2' => $pd->break_in_punch_id) );
					}


					if($pd->time_in_punch_id == null and $pd->time_out_punch_id != null and $pd->break_in_punch_id == null and $pd->break_out_punch_id == null )
					{
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $time_in, $emp_id) );
						$t_in = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, time_in_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $t_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_out, 'res2' => $pd->time_out_punch_id) );
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $break_in, $emp_id) );
						$b_in = DB::table('punches')->max('id');
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $break_out, $emp_id) );
						$b_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET break_in=:sur1, break_out=:t1, break_out_punch_id=:sur, break_in_punch_id=:sur2 WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time','t1' => 'On-time', 'sur' => $b_out, 'sur2' => $b_in, 'res2' => $emp_id, 'date2' => $dtr_date) );


					}

					if($pd->time_in_punch_id == null and $pd->time_out_punch_id != null and $pd->break_in_punch_id != null and $pd->break_out_punch_id != null )
					{
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $time_in, $emp_id) );
						$t_in = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, time_in_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $t_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_out, 'res2' => $pd->time_out_punch_id) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_in, 'res2' => $pd->break_in_punch_id) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_out, 'res2' => $pd->break_out_punch_id) );

					}

					if($pd->time_in_punch_id == null and $pd->time_out_punch_id != null and $pd->break_in_punch_id == null and $pd->break_out_punch_id != null )
					{
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $time_in, $emp_id) );
						$t_in = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, time_in_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $t_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_out, 'res2' => $pd->time_out_punch_id) );
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $break_in, $emp_id) );
								$b_in = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, break_in_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $b_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_out, 'res2' => $pd->break_out_punch_id) );

					}

					if($pd->time_in_punch_id == null and $pd->time_out_punch_id != null and $pd->break_in_punch_id != null and $pd->break_out_punch_id == null )
					{
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $time_in, $emp_id) );
						$t_in = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, time_in_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $t_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_out, 'res2' => $pd->time_out_punch_id) );
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $break_out, $emp_id) );
								$b_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, break_out_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $b_out, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_in, 'res2' => $pd->break_in_punch_id) );

					}

					if($pd->time_in_punch_id != null and $pd->time_out_punch_id == null and $pd->break_in_punch_id == null and $pd->break_out_punch_id == null )
					{
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $time_in, $emp_id) );
						$t_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_out=:sur1, time_out_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $t_out, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_in, 'res2' => $pd->time_out_punch_id) );
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $break_in, $emp_id) );
						$b_in = DB::table('punches')->max('id');
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $break_out, $emp_id) );
						$b_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET break_in=:sur1, break_out=:t1, break_out_punch_id=:sur, break_in_punch_id=:sur2 WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time','t1' => 'On-time', 'sur' => $b_out, 'sur2' => $b_in, 'res2' => $emp_id, 'date2' => $dtr_date) );


					}

					if($pd->time_in_punch_id != null and $pd->time_out_punch_id == null and $pd->break_in_punch_id != null and $pd->break_out_punch_id != null )
					{
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $time_in, $emp_id) );
						$t_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_out=:sur1, time_out_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $t_out, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_in, 'res2' => $pd->time_out_punch_id) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_in, 'res2' => $pd->break_in_punch_id) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_out, 'res2' => $pd->break_out_punch_id) );

					}

					if($pd->time_in_punch_id != null and $pd->time_out_punch_id == null and $pd->break_in_punch_id == null and $pd->break_out_punch_id != null )
					{
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $time_in, $emp_id) );
						$t_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_out=:sur1, time_out_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $t_out, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_in, 'res2' => $pd->time_out_punch_id) );
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $break_in, $emp_id) );
								$b_in = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, break_in_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $b_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_out, 'res2' => $pd->break_out_punch_id) );

					}

					if($pd->time_in_punch_id != null and $pd->time_out_punch_id == null and $pd->break_in_punch_id != null and $pd->break_out_punch_id == null )
					{
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $time_in, $emp_id) );
						$t_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_out=:sur1, time_out_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $t_out, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $time_in, 'res2' => $pd->time_out_punch_id) );
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $break_out, $emp_id) );
								$b_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, break_out_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $b_out, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_in, 'res2' => $pd->break_in_punch_id) );

					}


					if($pd->time_in_punch_id == null and $pd->time_out_punch_id == null and $pd->break_in_punch_id == null and $pd->break_out_punch_id == null )
					{
						
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $time_in, $emp_id) );
						$t_in = DB::table('punches')->max('id');
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $time_out, $emp_id) );
						$t_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, time_out=:t1, time_out_punch_id=:sur, time_in_punch_id=:sur2 WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time','t1' => 'On-time', 'sur' => $t_out, 'sur2' => $t_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $break_in, $emp_id) );
						$b_in = DB::table('punches')->max('id');
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $break_out, $emp_id) );
						$b_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET break_in=:sur1, break_out=:t1, break_out_punch_id=:sur, break_in_punch_id=:sur2 WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time','t1' => 'On-time', 'sur' => $b_out, 'sur2' => $b_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						

					}
					if($pd->time_in_punch_id == null and $pd->time_out_punch_id == null and $pd->break_in_punch_id != null and $pd->break_out_punch_id != null )
					{
						
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $time_in, $emp_id) );
						$t_in = DB::table('punches')->max('id');
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $time_out, $emp_id) );
						$t_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, time_out=:t1, time_out_punch_id=:sur, time_in_punch_id=:sur2 WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time','t1' => 'On-time', 'sur' => $t_out, 'sur2' => $t_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_in, 'res2' => $pd->break_in_punch_id) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_out, 'res2' => $pd->break_out_punch_id) );
						

					}

					if($pd->time_in_punch_id == null and $pd->time_out_punch_id == null and $pd->break_in_punch_id == null and $pd->break_out_punch_id != null )
					{
						
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $time_in, $emp_id) );
						$t_in = DB::table('punches')->max('id');
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $time_out, $emp_id) );
						$t_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, time_out=:t1, time_out_punch_id=:sur, time_in_punch_id=:sur2 WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time','t1' => 'On-time', 'sur' => $t_out, 'sur2' => $t_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $break_in, $emp_id) );
								$b_in = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, break_in_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $b_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_out, 'res2' => $pd->break_out_punch_id) );
						

					}

					if($pd->time_in_punch_id == null and $pd->time_out_punch_id == null and $pd->break_in_punch_id != null and $pd->break_out_punch_id == null )
					{
						
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $time_in, $emp_id) );
						$t_in = DB::table('punches')->max('id');
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
						 array($dtr_date, $time_out, $emp_id) );
						$t_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, time_out=:t1, time_out_punch_id=:sur, time_in_punch_id=:sur2 WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time','t1' => 'On-time', 'sur' => $t_out, 'sur2' => $t_in, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('INSERT INTO punches (date, time, employee_id) values (?, ?, ?)',
							 array($dtr_date, $break_out, $emp_id) );
								$b_out = DB::table('punches')->max('id');
						DB::statement('UPDATE punchstatus SET time_in=:sur1, break_out_punch_id=:sur WHERE employee_id=:res2 AND date=:date2',
					 		array('sur1' => 'On-time', 'sur' => $b_out, 'res2' => $emp_id, 'date2' => $dtr_date) );
						DB::statement('UPDATE punches SET time=:sur WHERE id=:res2',
					 		array('sur' => $break_in, 'res2' => $pd->break_in_punch_id) );
						

					}


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

			$break_in = DB::table('punchstatus')
			->join('punches', 'break_in_punch_id', '=', 'punches.id')
			->where('punchstatus.employee_id', '=', $emp_id)
			->where( DB::raw('MONTH(punchstatus.date)'), '=', $month)
			->where( DB::raw('YEAR(punchstatus.date)'), '=', $get_year)
			->orderby('punchstatus.date')
			->get();

			$break_out = DB::table('punchstatus')
			->join('punches', 'break_out_punch_id', '=', 'punches.id')
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
			$break = DB::table('employs')->join('empschedules', 'employs.id', '=', 'empschedules.employee_id')
			->join('schedules', 'empschedules.schedule_id', '=', 'schedules.id')
			->where('employs.id','=',  $emp_id)
			->where('schedules.require_break_punches', '=', 'Yes')
			->get();

			if($break == null)
			{
				$is_post = 'true';
			}
			else {
				$is_post = 'break';

			}
			$employee = DB::table('employs')->where('id', '=', $emp_id)->get();
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->lists('full_name', 'id');
			return View::make('dtr_report')
			->with('employs_id', $employs_id)
			->with('year', $year)
			->with('is_post', $is_post)
			->with('punch_in', $punch_in)
			->with('punch_out', $punch_out)
			->with('break_in', $break_in)
			->with('break_out', $break_out)
			->with('punch_day', $punch_day)
			->with('employee', $employee)
			->with('get_year', $get_year)
			->with('month_name', $month_name)
			->with('month', $month) 
			->with('emp_id', $emp_id)
			->with('dtr_date', $dtr_date);	
	}
	public function postManualDelete()
	{		
			$emp_id = Input::get('emp_id');
			$month = Input::get('month');
			$get_year = Input::get('year');
			$dtr_date = Input::get('dtr_date');
			$break_in = Input::get('break_in');
			$break_out = Input::get('break_out');
			$punch_date = DB::table('punchstatus')
			->where('employee_id', '=', $emp_id)
			->where('date', '=', $dtr_date)->get();
			
			if($punch_date != null and $break_in == null and $break_out == null)
			{
				foreach($punch_date as $pd){
					DB::statement("DELETE FROM punches WHERE id=:sid", array('sid'=>$pd->time_in_punch_id));
					DB::statement("DELETE FROM punches WHERE id=:sid", array('sid'=>$pd->time_out_punch_id));
				}
					DB::statement("DELETE FROM punchstatus WHERE employee_id=:sid AND date=:sdate", array('sid'=>$emp_id, 'sdate'=>$dtr_date));
			}

			if($punch_date != null and $break_in != null and $break_out != null)
			{
				foreach($punch_date as $pd){
					DB::statement("DELETE FROM punches WHERE id=:sid", array('sid'=>$pd->time_in_punch_id));
					DB::statement("DELETE FROM punches WHERE id=:sid", array('sid'=>$pd->time_out_punch_id));
					DB::statement("DELETE FROM punches WHERE id=:sid", array('sid'=>$pd->break_in_punch_id));
					DB::statement("DELETE FROM punches WHERE id=:sid", array('sid'=>$pd->break_out_punch_id));
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
			$break_in = DB::table('punchstatus')
			->join('punches', 'break_in_punch_id', '=', 'punches.id')
			->where('punchstatus.employee_id', '=', $emp_id)
			->where( DB::raw('MONTH(punchstatus.date)'), '=', $month)
			->where( DB::raw('YEAR(punchstatus.date)'), '=', $get_year)
			->orderby('punchstatus.date')
			->get();

			$break_out = DB::table('punchstatus')
			->join('punches', 'break_out_punch_id', '=', 'punches.id')
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
			$break = DB::table('employs')->join('empschedules', 'employs.id', '=', 'empschedules.employee_id')
			->join('schedules', 'empschedules.schedule_id', '=', 'schedules.id')
			->where('employs.id','=',  $emp_id)
			->where('schedules.require_break_punches', '=', 'Yes')
			->get();

			if($break == null)
			{
				$is_post = 'true';
			}
			else {
				$is_post = 'break';

			}
			$employee = DB::table('employs')->where('id', '=', $emp_id)->get();
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->lists('full_name', 'id');
			return View::make('dtr_report')
			->with('employs_id', $employs_id)
			->with('year', $year)
			->with('is_post', $is_post)
			->with('punch_in', $punch_in)
			->with('punch_out', $punch_out)
			->with('break_in', $break_in)
			->with('break_out', $break_out)
			->with('punch_day', $punch_day)
			->with('month', $month) 
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
		$month = Input::get('month');
		$get_year = Input::get('year');
		Session::put('month_query', $month);
		Session::put('year_query', $get_year);

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

	public function showAccumulatedHoursAdmin()
	{
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
			$user = DB::table('employs')
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
				$employers = array('id' => $employs->lname,'name'=> $employs->fname, 'total' => $total, 'acchrs' => $acchrs,'overtime' =>$overtime);
				array_push($employee_lists, $employers);
			}
			
			return View::make('accumulatedhours')
				->with('now',$now)
				->with('total',$total)
				->with('overtime',$overtime)
				->with('acchrs',$acchrs)
				->with('employee_lists',$employee_lists)
				->with('to',$to)
				->with('dateto',$dateto)
				->with('user',$user);

	}

	public function postshowAccumulatedHoursAdmin()
	{
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
			$user = DB::table('employs')
			->get();
			$employers=array();
			$employee_lists = array();
		
			
			foreach($user as $employs)
			{	
				$hrs = 0;
				$othrs =0;
				$total = 0;
				$totalminutes =0;
				$overtime = 0;
				$overtimemin =0;
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
				$employers = array('id' => $employs->lname, 'name'=> $employs->fname, 'total' => $total, 'acchrs' => $acchrs,'overtime' =>$overtime);
				array_push($employee_lists, $employers);
			}
			
			return View::make('accumulatedhours')
				->with('now',$now)	
				->with('total',$total)
				->with('overtime',$overtime)
				->with('acchrs',$acchrs)
				->with('employee_lists',$employee_lists)
				->with('to',$to)
				->with('user',$user)
				->with('dateto',$dateto);	
	}
	public function showPunctualityAssessmentAdmin()
	{
			$employers=array();
			$employee_lists = array();
			$dateto = "";
			$to = "";
			$datenow = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $datenow->format('Y-m-d');
			$user = DB::table('employs')
			->get();
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
				$employers = array('id' => $employs->lname, 'name'=> $employs->fname,'earlybreak' => $earlybreak, 'ontime' => $ontime,
								   'longbreak' => $longbreak,'late' => $late,'earlyout' => $earlyout,'absent' =>$absent);
				array_push($employee_lists, $employers);
			}
			return View::make('punctualityassessment')
	
				->with('ontime',$ontime)
				->with('late',$late)
				->with('absent',$absent)
				->with('earlybreak',$earlybreak)
				->with('longbreak',$longbreak)
				->with('earlyout',$earlyout)
				->with('now',$now)
				->with('to',$to)
				->with('employee_lists',$employee_lists)
				->with('dateto',$dateto)
				->with('user',$user);
	
	}
	public function postshowPunctualityAssessmentAdmin()
	{
		$datefrom = Input::get('datefrom');
			$now = Input::get('datefrom');
			$to = "to";
			$dateto = Input::get('dateto');
			$employers=array();
			$employee_lists = array();
			$user = DB::table('employs')
			->get();

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
				$employers = array('id' => $employs->lname, 'name'=> $employs->fname,'earlybreak' => $earlybreak, 'ontime' => $ontime,
								   'longbreak' => $longbreak,'late' => $late,'earlyout' => $earlyout,'absent' =>$absent);
				array_push($employee_lists, $employers);
			}
			return View::make('punctualityassessment')
				->with('ontime',$ontime)
				->with('late',$late)
				->with('absent',$absent)
				->with('earlybreak',$earlybreak)
				->with('longbreak',$longbreak)
				->with('earlyout',$earlyout)
				->with('now',$now)
				->with('employee_lists',$employee_lists)
				->with('dateto',$dateto)
				->with('to',$to)
				->with('user',$user);
				
	}
/*ROCK WELL =====================================================================*/
	


	public function postPdfreportsleave()
	{
		$month = '';
		$year = '';
		$month = Input::get('month');
		$year = Input::get('year');
		Session::put('month_query', $month);
		Session::put('year_query', $year);
		return View::make('reportsleave')
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

	public function showLeaveQuery()
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

			
		
		return View::make('leave_query')
		->with('employs',$employs)
		->with('sick_leave',$sick_leave)
		->with('vacation_leave',$vacation_leave)
		->with('force_leave',$force_leave);

	}

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
		$employs = DB::table('employs')
		->where('status','!=','Inactive')
		->where('status','!=','Terminated')
		->get();
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
	
	public function chuchu()
	{
		return View::make('dailytimerecord');
	}	

	public function showPdfAssessment()
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
		return View::make('assessment_report')
		->with('employs_id',$employs_id)
		->with('emp_id', $emp_id)
		->with('year',$year)
		->with('is_post', $is_post);
	}

	public function showAccumulatedDanceCraze()
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
		return View::make('accumulated_admin')
		->with('employs_id',$employs_id)
		->with('emp_id', $emp_id)
		->with('year',$year)
		->with('is_post', $is_post);

		
		

	}//show accumulated dance craze

}
