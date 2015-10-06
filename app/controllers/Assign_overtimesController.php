<?php

class Assign_overtimesController extends BaseController {

	/**
	 * Assign_overtime Repository
	 *
	 * @var Assign_overtime
	 */
	protected $assign_overtime;

	public function __construct(Assign_overtime $assign_overtime)
	{
		$this->assign_overtime = $assign_overtime;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$assign_overtimes= Assign_overtime::paginate(9);
		
		$overtime_policies = DB::table('overtime_policies')
		->lists('overtime_name', 'id');
		$employees = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->where('status','!=','Inactive')
			->where('status','!=','Terminated')
			->orderBy('lname', 'asc')
			->lists('full_name', 'id');
		return View::make('assign_overtimes.index', compact('assign_overtimes'))
		
		->with('assign_overtimes',$assign_overtimes)
		->with('employees',$employees)
		->with('overtime_policies',$overtime_policies);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('assign_overtimes.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$input = Input::all();
		$validation = Validator::make($input, Assign_overtime::$rules);
		$overtime_id=DB::table('assign_overtimes')->max('id');
		$overtime_id=$overtime_id +1;
		if ($validation->passes())
		{
		
			$assign_overtime = new Assign_overtime;
			$assign_overtime->name = Input::get('name');
			$assign_overtime->overtime_id = Input::get('overtime_id');

			$active_after=Input::get('active_after');
			$Allowed_no_of_hours=Input::get('Allowed_number_of_hours');
			$range_to=Input::get('range_to');
			$range_from=Input::get('range_from');
			$employees =Input::get('employees');
			foreach ($employees as $employee) 
			{
				DB::table('overtime_subordinates')->insert(array(
					array('overtime_id'=>$overtime_id,'employee_id'=>$employee,'active_after'=>$active_after,'Allowed_number_of_hours'=>$Allowed_no_of_hours,'range_from'=>$range_from,'range_to'=>'$range_to')
					));
				}

			$assign_overtime->range_from=Input::get('range_from');
			$assign_overtime->range_to=Input::get('range_to');

			$assign_overtime->save();
		   

			return Redirect::route('assign_overtimes.index');
		}

		return Redirect::route('assign_overtimes.index')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	
		public function show($id)
		{
			$assign_overtime = $this->assign_overtime->findOrFail($id);
			$users = DB::table('overtime_subordinates')->count();
			$employee = DB::table('employs')->get();
			$assigned = DB::table('overtime_subordinates')
							->select('employee_id')
							->where('overtime_id','=',$assign_overtime->id)
							->lists('employee_id');

			$employee_lists = array();
			foreach ($employee as $employees) {
							$employ = DB::table('employs')
							->whereIn('id',$assigned)
							->get();
						
				array_push($employee_lists, $employ);
			}
			sort($employee_lists);
			return View::make('assign_overtimes.show', compact('assign_overtime'))
			->with('users',$users)
			->with('employee_lists', $employee_lists);
		}
	

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$assign_overtime = $this->assign_overtime->find($id);
		$overtime_policies = DB::table('overtime_policies')
		->lists('overtime_name', 'id');
		$employees = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->orderBy('lname', 'asc')
			->lists('full_name', 'id');

		if (is_null($assign_overtime))
		{
			return Redirect::route('assign_overtimes.index');
		}

		return View::make('assign_overtimes.edit', compact('assign_overtime'))
		->with('employees',$employees)
		->with('overtime_policies',$overtime_policies);
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
		$validation = Validator::make($input, Assign_overtime::$rules);

		if ($validation->passes())
		{
			$assign_overtime = $this->assign_overtime->find($id);
			$assign_overtime->update($input);

			return Redirect::route('assign_overtimes.show', $id);
		}

		return Redirect::route('assign_overtimes.edit', $id)
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
		$this->assign_overtime->find($id)->delete();

		return Redirect::route('assign_overtimes.index');
	}

}


