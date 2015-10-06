<?php

class Create_requestsController extends BaseController {

	/**
	 * Create_request Repository
	 *
	 * @var Create_request
	 */
	protected $create_request;

	public function __construct(Create_request $create_request)
	{
		$this->create_request = $create_request;
	}



	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$create_requests = DB::table('create_requests')->where('employee_id', '=', $id)->where('status', '=', 'pending')->get();
			$request_types = DB::table('request_types')->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			return View::make('create_requests.index', compact('create_requests'))
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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		date_default_timezone_set('Asia/Manila');
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$create_requests = create_request::where('employee_id', '=', $id)->get();
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$request_types = DB::table('request_types')
			->lists('request_type', 'request_type');
			return View::make('create_requests.create')
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('supervisor', $supervisor)
				->with('create_requests', $create_requests)
				->with('request_types', $request_types);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$s_leave = 0;
		$v_leave = 0;
		$f_leave = 0;
		$validation = Validator::make($input, Create_request::$rules);
		$emp_id = Session::get('empid', 'default');
		$emp_date = DB::table('employs')->where('employs.id', '=', $emp_id)->get();
		$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');

			foreach($emp_date as $emp){

			$hdate = $emp->hire_date;
			
			$ts1=strtotime($hdate);
			$ts2=strtotime($now);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$day1 = date('d', $ts1); /* I'VE ADDED THE DAY VARIABLE OF DATE1 AND DATE2 */
			$day2 = date('d', $ts2);

			$day_counter = (($year2 - $year1) * 360) + (($month2 - $month1)*12) + ($day2 - $day1) + 1;
		if ($day_counter >= 360)
		{

	
			$now = Input::get('end_date');
			$hdate = Input::get('start_date');
			$ts1=strtotime($hdate);
			$ts2=strtotime($now);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$day1 = date('d', $ts1); /* I'VE ADDED THE DAY VARIABLE OF DATE1 AND DATE2 */
			$day2 = date('d', $ts2);

			$deduct = (($year2 - $year1) * 360) + (($month2 - $month1)*12) + ($day2 - $day1) + 1;


			$leavecredits = DB::table('leavecredits')->get();
			$emp_id = Session::get('empid', 'default');

			foreach ($leavecredits as $leavecredit)
		{
	
		if ($leavecredit->employee_id == $emp_id)
			{
			$employee_id = $emp_id;
			$type = Input::get('request_type');
			if ($type == 'Sick Leave')
				{
				$s_leave = $deduct + $leavecredit->sick_leave;
				$v_leave = $leavecredit->vacation_leave;
				$f_leave = $leavecredit->force_leave;
				}
			if ($type == 'Vacation Leave') {
				$s_leave = $leavecredit->sick_leave;
				$v_leave = $deduct + $leavecredit->vacation_leave;
				$f_leave = $leavecredit->force_leave;
				}

			if ($type == 'Force Leave') {
				$s_leave = $leavecredit->sick_leave;
				$v_leave = $leavecredit->vacation_leave;
				$f_leave = $deduct + $leavecredit->force_leave;
				}
			}
		} 

			$date = new DateTime("now", new DateTimeZone("Asia/Singapore"));
			$now = $date->format('Y-m-d');
			$i = 0;
			$credits = DB::table('leavecredits')->get();
			   // MySQL datetime format
			$employs = DB::table('employs')->where('employs.id', '=', $emp_id)->get();
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

									$sick_leaves[$i] = (($totyear *15) + $totmonth * 1.25) - $s_leave;

									$vacation_leaves[$i] = (($totyear *15) + $totmonth * 1.25) - $v_leave;
								

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
								$force_leaves[$i] = 5 - $f_leave;
								$vacation_leaves[$i] = (($totyear *15) + $totmonth * 1.25) - $force_counter - $v_leave;

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
								$sick_leaves[$i] = ($diff * 1.25) - $s_leave;
								$vacation_leaves[$i] = ($diff * 1.25) - $v_leave; }}
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
								$force_leaves[$i] = 5 - $f_leave;
								$vacation_leaves[$i] = ($diff * 1.25) - $force_leaves[$i] - $v_leave;}}
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
						
						$check = DB::table('create_requests')->where('employee_id', '=', $emp_id)->where('status', '=', 'pending')->get();
					
						if($check == null)
						{
							if ($validation->passes() && $sick_leaves[$i] >= 0 && $vacation_leaves[$i] >= 0 && $force_leaves[$i] >= 0)
							{
								$this->create_request->create($input);

								return Redirect::route('create_requests.index')
									->with('message', 'Leave successfully filed, now pending approval from your supervisor');
							}
							else {
							Session::flash('messageb', 'Insufficient Leave Credits');
							return Redirect::route('create_requests.create')
								->withInput()
								->withErrors($validation)
								->with('message', 'There were validation errors.');
						
							}
						}
						else {
							Session::flash('messageb', 'There is still a pending request');
							return Redirect::route('create_requests.create')
								->withInput()
								->withErrors($validation)
								->with('message', 'There were validation errors.');
						}
						}
							$i = $i + 1;

					}
					else{
						Session::flash('messageb', 'Employee is not allowed to request for Leave');
							return Redirect::route('create_requests.create')
								->withInput()
								->withErrors($validation)
								->with('message', 'There were validation errors.');
						}
					}

				}
	

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		date_default_timezone_set('Asia/Manila');
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$create_request = $this->create_request->findOrFail($id);
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$request_type = DB::table('request_types')
			->lists('request_type', 'request_type');
			return View::make('create_requests.show', compact('create_request'))
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('supervisor', $supervisor)
				->with('create_request', $create_request)
				->with('request_type', $request_type);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		date_default_timezone_set('Asia/Manila');
		if (Session::has('empid') && Session::has('empname') && Session::has('empemail')) {
			$id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$email = Session::get('empemail', 'default');
			$level = Session::get('emplevel', 'default');
			$create_request = create_request::find($id);
			$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
			$request_type = DB::table('request_types')
			->lists('request_type', 'request_type');
			return View::make('create_requests.edit', compact('create_request'))
				->with('id', $id)
				->with('name', $name)
				->with('email', $email)
				->with('level', $level)
				->with('supervisor', $supervisor)
				->with('create_request', $create_request)
				->with('request_type', $request_type);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Create_request::$rules);

		if ($validation->passes())
		{
			$create_request = $this->create_request->find($id);
			$create_request->update($input);

			return Redirect::route('create_requests.show', $id);
		}

		return Redirect::route('create_requests.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->create_request->find($id)->delete();

		return Redirect::route('create_requests.index');
	}

}
