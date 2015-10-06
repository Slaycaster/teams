<?php

class EmpschedulesController extends BaseController {

	/**
	 * Empschedule Repository
	 *
	 * @var Empschedule
	 */
	protected $empschedule;

	public function __construct(Empschedule $empschedule)
	{
		$this->empschedule = $empschedule;
	}
	public function removeFromSched()
	{
		$empscheds = DB::table('empschedules')->get();
		$employs = DB::table('employs')->get();
		$departments = DB::table('departments')->get();
		$branches = DB::table('branches')->get();
		$schedule = ['Select a schedule...'] + DB::table('schedules')
		->lists('schedule_name', 'id');
		
		return View::make('empschedules.remove')
		->with('schedule',$schedule)
		->with('employs',$employs)
		->with('empscheds',$empscheds)
		->with('departments',$departments)
		->with('branches',$branches);

	}
	public function postRemoveFromSched()
	{
		$id_dropdown = Input::get('schedule_id');
		$empscheds = DB::table('empschedules')->where('schedule_id', '=', $id_dropdown)->get();
		$employs = DB::table('employs')->get();
		$departments = DB::table('departments')->get();
		$branches = DB::table('branches')->get();
		$schedule = ['Select a schedule...'] + DB::table('schedules')
		->lists('schedule_name', 'id');
		
		return View::make('empschedules.remove')
		->with('id_dropdown', $id_dropdown)
		->with('schedule',$schedule)
		->with('employs',$employs)
		->with('empscheds',$empscheds)
		->with('departments',$departments)
		->with('branches',$branches);

	}
	public function delEmployeeFromSched()
	{
			$emp_scheds = DB::table('empschedules')->get();
			foreach ($emp_scheds as $emp_sched) {
				if (Input::has($emp_sched->id)) {
					DB::table('empschedules')
						->where('id', '=', $emp_sched->id)
						->delete();
				}
			}

			return View::make('transaction');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$empschedules = $this->empschedule->all();
		$schedule = Schedule::paginate(9);
		$employs=DB::table('employs')
		->where('status','!=','Inactive')
		->where('status','!=','Terminated')
		->whereNotExists(function($query)
            {
                $query->select(DB::raw('employee_id'))
                      ->from('empschedules')
                      ->whereRaw('empschedules.employee_id = employs.id');
            })->get();
		$schedules = DB::table('schedules')->get();
		return View::make('empschedules.index', compact('empschedules'))
		->with('schedule',$schedule)
		->with('empschedules',$empschedules)
		->with('schedules',$schedules)
		->with('employs',$employs);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		$departments=DB::table('departments')
		->get();
		$schedule = DB::table('schedules')
		->lists('schedule_name', 'id');
		$employs = DB::table('employs')
		->where('status','!=','Inactive')
		->where('status','!=','Terminated')
		->whereNotExists(function($query)
            {
                $query->select(DB::raw('employee_id'))
                      ->from('empschedules')
                      ->whereRaw('empschedules.employee_id = employs.id');
            })->get();
		$branches = DB::table('branches')->get();
		//$employs = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))->orderBy('lname', 'asc')->get();
		return View::make('empschedules.create')
		->with('schedule',$schedule)
		->with('employs', $employs)
		->with('departments',$departments)
		->with('branches',$branches);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Empschedule::$rules);

		if ($validation->passes())
		{	$id = DB::table('empschedules')->max('id');
			$schedule_id = Input::get('schedule_id');
			$employs = DB::table('employs')->get();
			foreach ($employs as $employ) {
				if (Input::has($employ->id)) {
					//Save here
					$employee_id = Input::get($employ->id);
					$id = $id + 1;
					DB::table('empschedules')->insert(array(
						array('id' => $id, 'schedule_id' => $schedule_id, 'employee_id' => $employee_id)
				));
				}
			}

			/*
			//$empschedule = new Empschedule;
			$id = DB::table('empschedules')->max('id');
			
			$employs = Input::get('employs');
			$schedule_id = Input::get('schedule_id');
			foreach ($employs as $employ) {	
				$id = $id + 1;
					DB::table('empschedules')->insert(array(
						array('id' => $id, 'schedule_id' => $schedule_id, 'employee_id' => $employ)
				));
			}
				
			*/
			Session::flash('message2', 'Successfully added to schedule');
			return Redirect::route('empschedules.create');
		}

		return Redirect::route('empschedules.create')
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
		
		$empschedule = $this->empschedule->find($id);

		return View::make('empschedules.show', compact('empschedule'));
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$empschedule = $this->empschedule->find($id);

		if (is_null($empschedule))
		{
			return Redirect::route('empschedules.index');
		}

		return View::make('empschedules.edit', compact('empschedule'));
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
		$validation = Validator::make($input, Empschedule::$rules);

		if ($validation->passes())
		{
			$empschedule = $this->empschedule->find($id);
			$empschedule->update($input);

			return Redirect::route('empschedules.show', $id);
		}

		return Redirect::route('empschedules.edit', $id)
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
		$this->empschedule->find($id)->delete();

		return Redirect::route('empschedules.index');
	}

	public function addExtraEmployees()
	{
		$empschedule_id = Input::get('empschedule_id');
		$new_employees = Input::get('new_employees');

			foreach ($new_employees as $new_employee) {	
				DB::table('empschedules')->insert(array(
					array('id' => $empschedule_id, 'employee_id' => $new_employee)
				));
			}
				
			return Redirect::route('empschedules.index');
	}
	public function removeEmployees()
	{
		
		$empschedule_id = Input::get($emp->id);
		$employee_id = Input::get('employee_id');

			DB::table('empschedules')
				->where('id', '=', $empschedule_id)
				->where('employee_id', '=', $employee_id)
				->delete();
				
			return Redirect::route('empschedules.index');

	}

	

}
