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

	public function showManual()
	{
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$employees = DB::table('employs')->where('level_id', '=', '0')->get();
			$requests = DB::table('create_requests')->get();
			$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->lists('full_name', 'id');
		return View::make('dtr_report')
				->with('employs_id',$employs_id)
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('employees', $employees)
				->with('requests', $requests);
		
		
	}

	public function showDashboard()
	{	$request= DB::table('create_requests')->where('status', '=', 'approved')->count();
		return View::make('dashboard')
		->with('request', $request);
	}

	public function showApproved()
	{		
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

			$diff[$i] = (($year2 - $year1) * 360) + (($month2 - $month1)*12) + ($day2 - $day1);
			$i++;
		}
} else {
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
								$force_leave[$i] = 5;
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
								$force_leave[$i] = 5;
								$vacation_leave[$i] = ($diff * 1.25) - $force_leave[$i] - $credit->vacation_leave;}}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$force_leave[$i] = 5;
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
		$create_requests = DB::table('create_requests')->where('employee_id', '=', $emp_id)->where('status', '=', 'approved')->get();
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
			if ($type == 'sick_leave')
				{
				$sick_leave = Input::get('deduction') + $leavecredit->sick_leave;
				$vacation_leave = $leavecredit->vacation_leave;
				}
			else {
				$sick_leave = $leavecredit->sick_leave;
				$vacation_leave = Input::get('deduction') + $leavecredit->vacation_leave;
				}

				DB::statement('UPDATE leavecredits SET sick_leave=:leave1 , vacation_leave=:leave2   WHERE employee_id=:res2',
				 array('leave1' => $sick_leave, 'leave2' => $vacation_leave, 'res2' => $emp_id) );			}
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
				}
			else {
				$sick_leave = '0';
				$vacation_leave = Input::get('deduction');
				}
			DB::statement('INSERT INTO leavecredits (employee_id, sick_leave, vacation_leave) values (?, ?, ?)',
				 array($emp_id, $sick_leave, $vacation_leave) );
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
								$force_leaves[$i] = 5;
								$vacation_leaves[$i] = (($totyear *15) + $totmonth * 1.25) - $force_counter - $credit->vacation_leave;

								}
							}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$force_counter = 5 * $totyear;
									$force_leaves[$i] = 5;
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
								$force_leaves[$i] = 5;
								$vacation_leaves[$i] = ($diff * 1.25) - $force_leaves[$i] - $credit->vacation_leave;}}
								$cred = DB::table('leavecredits')->where('employee_id', '=', $employee->id)->get();
								if ($cred == null)
								{
									$force_leave[$i] = 5;
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


			
		
		return View::make('leavecredits')
		->with('employs',$employs)
		->with('sick_leave',$sick_leaves)
		->with('vacation_leave',$vacation_leaves)
		->with('force_leave',$force_leaves);



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
