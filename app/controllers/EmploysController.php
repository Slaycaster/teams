<?php

class EmploysController extends BaseController {

	/**
	 * Employee Repository
	 *
	 * @var Employee
	 */
	protected $employee;

	public function __construct(Employ $employee)
	{
		$this->employee = $employee;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$employees = Employ::paginate(8);
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP-'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$departments = DB::table('departments')->get();
		$levels = DB::table('levels')->get();
		$departments_id=DB::table('departments')
		->where('status','!=','Disabled')
		->lists('name','id');
		$contracts= DB::table('contracts')->get();
		$contracts_id=DB::table('contracts')
		->lists('contract_name','id');
		$jobtitles_id=DB::table('jobtitles')
		->lists('jobtitle_name','id');
		$level_id=DB::table('levels')
		->lists('name','id');
		$hierarchies=DB::table('hierarchies')->get();
		$hierarchies_id=DB::table('hierarchies')
		->lists('hierarchy_name','id');
		$jobtitles=DB::table('jobtitles')->get();
		return View::make('employs.index', compact('employs'))
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('departments',$departments)
		->with('departments_id',$departments_id)
		->with('contracts_id',$contracts_id)
		->with('contracts',$contracts)
		->with('contracts_id',$contracts_id)
		->with('jobtitles_id',$jobtitles_id)
		->with('jobtitles',$jobtitles)
		->with('hierarchies',$hierarchies)
		->with('levels',$levels)
		->with('level_id',$level_id)
		->with('hierarchies_id',$hierarchies_id);
	}

	public function postSearch()
	{
		$q = Input::get('query');
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP-'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$employees = DB::table('employs')->whereRaw("MATCH(employee_number, lname, fname) AGAINST(? IN BOOLEAN MODE)", array($q))->paginate(9);
		$departments = DB::table('departments')->get();
		$departments_id=DB::table('departments')
		->lists('name','id');
		$levels = DB::table('levels')->get();
		$level_id=DB::table('levels')
		->lists('name','id');
		$contracts= DB::table('contracts')->get();
		$contracts_id=DB::table('contracts')
		->lists('contract_name','id');
		$hierarchies=DB::table('hierarchies')->get();
		$hierarchies_id=DB::table('hierarchies')
		->lists('hierarchy_name','id');
		$jobtitles=DB::table('jobtitles')->get();
		$jobtitles_id=DB::table('jobtitles')
		->lists('jobtitle_name','id');
		return View::make('employs.index')
			->with('emp_id', $emp_id)
			->with('employees',$employees)
			->with('departments',$departments)
			->with('departments_id',$departments_id)
			->with('contracts',$contracts)
			->with('contracts_id',$contracts_id)
			->with('levels',$levels)
			->with('level_id',$level_id)
			->with('jobtitles',$jobtitles)
			->with('jobtitles_id',$jobtitles_id)
			->with('hierarchies',$hierarchies)
			->with('hierarchies_id',$hierarchies_id);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP-'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$departments=DB::table('departments')
		->lists('name','id');
		$contracts=DB::table('contracts')
		->lists('contract_name','id');
		$jobtitles=DB::table('jobtitles')
		->lists('jobtitle_name','id');
		return View::make('employs.create')
		->with('emp_id', $emp_id)
		->with('departments',$departments)
		->with('jobtitles',$jobtitles)
		->with('contracts',$contracts);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Rsesponse
	 */
	public function store()
	{
		// $then will first be a string-date
		$then = strtotime(Input::get('date_of_birth'));
		//The age to be over, over +18
    	$min = strtotime('+18 years', $then);

    	$curdate = strtotime(Input::get('hire_date'));

    	$mydate = strtotime(date("Y-m-d"));
    	if((time() < $min) || ($curdate < $mydate))  
    	{
    		if((time() < $min))
    		{
    			Session::flash('age_valid', 'Employee is under 18.');
      		 	return Redirect::route('employs.index');	
    		}
    		else if(($curdate < $mydate))
    		{
    			Session::flash('age_valid', 'Employee must be hired above current date.');
      		 	return Redirect::route('employs.index');
    		}
    		
    	} 
    	else
    	{
    		
    		$id = DB::table('employs')->max('id');
			$id = $id + 1;
			$input = Input::all();
			$validation = Validator::make($input, Employ::$rules);
			$file = array('image' => Input::file('picture_path'));
			$emp_fname = preg_replace('/\s+/', '', Input::get('fname'));
			QrCode::format('png');

			if ($validation->passes())
			{
				$destinationPath = 'employees'; //upload path
				$extension = Input::file('picture_path')->getClientOriginalExtension(); //getting image extension
				$fileName = $id.''.Input::get('lname').''.$emp_fname.'.'.$extension; //renaming image to -> 1FernandezDenimar.jpg
				Input::file('picture_path')->move($destinationPath, $fileName);

				$employee = new Employ;
				$employee->employee_number = Input::get('employee_number');
				$employee->lname = Input::get('lname');
				$employee->fname = Input::get('fname');
				$employee->midinit = Input::get('midinit');
				$employee->picture_path = 'employees/'.$id.''.Input::get('lname').''.$emp_fname.'.jpg';
				$employee->date_of_birth = Input::get('date_of_birth');
				$employee->street = Input::get('street');
				$employee->barangay = Input::get('barangay');
				$employee->city = Input::get('city');
				
	
				$employee->phone = Input::get('phone');
				$employee->email = Input::get('email');
				$employee->hire_date = Input::get('hire_date');
				$employee->status = Input::get('status');
				QrCode::size(100)->generate(Input::get('employee_number'), public_path().'/qrcodes/'.$id.''.Input::get('lname').''.$emp_fname.'.png');
				$employee->qr_code = 'qrcodes/'.$id.''.Input::get('lname').''.$emp_fname.'.png';
				$employee->jobtitle_id = Input::get('jobtitle_id');
				$employee->department_id = Input::get('department_id');
				$employee->contract_id = Input::get('contract_id');
				$permit = Input::get('permission');

				if ($permit == '0') 
				{
					$employee->level_id = '0';
				}
				else if($permit == '1')
				{
					$employee->level_id = Input::get('level_id');
				}
				else if($permit == '2')
				{
					$employee->level_id = '30';
				}	

				
				$employee->save();

				$employee = new Employ;

				$str_random = Str::random($length = 8);

										//placeholder values for variable
				DB::statement('UPDATE employs SET password=:sur WHERE id=:res2',
				 array('sur' => $str_random, 'res2' => $id) );
				return Redirect::route('employs.index');
			}

			return Redirect::route('employs.index')
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');
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
		$employee = $this->employee->findOrFail($id);
		$departments = DB::table('departments')->get();
		$contracts= DB::table('contracts')->get();
		$hierarchies=DB::table('hierarchies')->get();
		$jobtitles=DB::table('jobtitles')->get();
		$levels=DB::table('levels')->get();
		return View::make('employs.show', compact('employ'))
			->with('employee', $employee)
			->with('departments',$departments)
			->with('jobtitles',$jobtitles)
			->with('contracts',$contracts)
			->with('levels',$levels);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		 
		$employee = $this->employee->find($id);
		$departments=DB::table('departments')
		->lists('name','id');
		$contracts=DB::table('contracts')
		->lists('contract_name','id');
		$hierarchies=DB::table('hierarchies')
		->lists('id','id');
		$jobtitles=DB::table('jobtitles')
		->lists('jobtitle_name','id');
		$levels=DB::table('levels')
		->lists('name','id');

		if (is_null($employee))
		{
			return Redirect::route('employs.index');
		}

		return View::make('employs.edit', compact('employ'))
		->with('employee',$employee)
		->with('levels',$levels)
		->with('departments',$departments)
		->with('contracts',$contracts)
		->with('jobtitles',$jobtitles)
		->with('hierarchies',$hierarchies);
		
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
		$file = array('image' => Input::file('picture_path'));
		$emp_fname = preg_replace('/\s+/', '', Input::get('fname'));
		QrCode::format('png');
		$picture_path = Input::file('picture_path');
			if ($picture_path != null)
			{
			$destinationPath = 'employees'; //upload path
			$extension = Input::file('picture_path')->getClientOriginalExtension(); //getting image extension
			$fileName = $id.''.Input::get('lname').''.$emp_fname.'.'.$extension; //renaming image to -> 1FernandezDenimar.jpg
			Input::file('picture_path')->move($destinationPath, $fileName);
			}
			$employee = $this->employee->find($id);
			$employee->employee_number = Input::get('employee_number');
			$employee->lname = Input::get('lname');
			$employee->fname = Input::get('fname');
			$employee->midinit = Input::get('midinit');
			if ($picture_path == null)
			{
			$employee->picture_path = 'employees/'.$id.''.Input::get('lname').''.$emp_fname.'.jpg';
			}
			else {
			$employee->picture_path = 	Input::get('picture_path');
			}
			$employee->date_of_birth = Input::get('date_of_birth');
			$employee->street = Input::get('street');
			$employee->barangay = Input::get('barangay');
			$employee->city = Input::get('city');
			
				
			$employee->phone = Input::get('phone');
			$employee->email = Input::get('email');
			$employee->hire_date = Input::get('hire_date');
			$employee->status = Input::get('status');
			QrCode::size(100)->generate(Input::get('employee_number'), public_path().'/qrcodes/'.$id.''.Input::get('lname').''.$emp_fname.'.png');
			$employee->qr_code = 'qrcodes/'.$id.''.Input::get('lname').''.$emp_fname.'.png';
			$employee->jobtitle_id = Input::get('jobtitle_id');
			$employee->department_id = Input::get('department_id');
			$employee->contract_id = Input::get('contract_id');
			$permit = Input::get('permission');

				if ($permit == '0') 
				{
					$employee->level_id = '0';
				}
				else if($permit == '1')
				{
					$employee->level_id = Input::get('level_id');
				}
				else if($permit == '2')
				{
					$employee->level_id = '30';
				}	

			$employee->jobtitle_id = Input::get('jobtitle_id');
			$employee->update();

			return Redirect::route('employs.show', $id);
		
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->employee->find($id)->delete();

		return Redirect::route('employs.index');
	}

}