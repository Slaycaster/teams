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
	{
		return View::make('dashboard');
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
		$leavecredits = DB::table('leavecredits')->get();
		return View::make('leavecredits')
		->with('employs',$employs)
		->with('leavecredits',$leavecredits);

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
