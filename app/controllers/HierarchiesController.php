<?php

class HierarchiesController extends BaseController {

	/**
	 * Hierarchy Repository
	 *
	 * @var Hierarchy
	 */
	protected $hierarchy;

	public function __construct(Hierarchy $hierarchy)
	{
		$this->hierarchy = $hierarchy;
	}

	/**
	 * Display a listing of the resource.
	 * oh yeah
	 * @return Response
	 */


	public function index()
	{	
		$hierarchies = $this->hierarchy->all();
		$hierarchy = Hierarchy::paginate(9);
		$employs=DB::table('employs')->get();
     	$levels = ['Select a level...'] + DB::table('levels')
		->lists('name', 'id');	
		$levelss = DB::table('levels')->get();
		$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->lists('full_name', 'id');
		$supervisors = Employ::select(DB::raw('concat(lname, ", ", fname) as full_name'), 'id' )->where('level_id', '>', '0')->orderBy('lname', 'asc')->lists('full_name', 'id');
		$subordinates = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, employs.id'))
		->where('status','!=','Inactive')
		->where('status','!=','Terminated')
		 ->whereNotExists(function($query)
            {
                $query->select(DB::raw('employee_id'))
                      ->from('hierarchy_subordinates')
                      ->whereRaw('hierarchy_subordinates.employee_id = employs.id');
            })
		->where('level_id', '=', '0')->orderBy('lname', 'asc')->lists('full_name', 'id');
		return View::make('hierarchies.index', compact('hierarchies'))
		->with('hierarchy',$hierarchy)
		->with('hierarchies',$hierarchies)
		->with('employs',$employs)
		->with('employs_id',$employs_id)
		->with('levels', $levels)
		->with('levelss',$levelss)
		->with('supervisors', $supervisors)
		->with('subordinates', $subordinates);
	}

	public function postindex()
	{	
		$hierarchies = $this->hierarchy->all();
		$hierarchy = Hierarchy::paginate(9);
		$employs=DB::table('employs')->get();
     	$levels = ['Select a level...'] + DB::table('levels')
		->lists('name', 'id');
		$levelss = DB::table('levels')->get();
		$id_dropdownname = Input::get('levels_id');
		$id_dropdown = Input::get('levels_id');	
		$employs_id = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			->lists('full_name', 'id');
		$supervisors = Employ::select(DB::raw('concat(lname, ", ", fname) as full_name'), 'id' )->where('level_id', '=', $id_dropdown)->orderBy('lname', 'asc')->lists('full_name', 'id');
		$subordinates = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, employs.id'))
		->where('status','!=','Inactive')
		->where('status','!=','Terminated')
		 ->whereNotExists(function($query)
            {
                $query->select(DB::raw('employee_id'))
                      ->from('hierarchy_subordinates')
                      ->whereRaw('hierarchy_subordinates.employee_id = employs.id');
            })
		 ->where('level_id', '>', $id_dropdown)->orWhere('level_id', '=', '0')->orderBy('lname', 'asc')->lists('full_name', 'id');
		return View::make('hierarchies.index', compact('hierarchies'))
		->with('hierarchy',$hierarchy)
		->with('id_dropdown', $id_dropdown)
		->with('id_dropdownname', $id_dropdownname)
		->with('hierarchies',$hierarchies)
		->with('employs',$employs)
		->with('employs_id',$employs_id)
		->with('levels', $levels)
		->with('levelss',$levelss)
		->with('supervisors', $supervisors)
		->with('subordinates', $subordinates);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$levels = DB::table('levels')
            ->join('employs', 'levels.id', '=', 'employs.level_id')
            ->get();
		$supervisors = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))->where('level_id', '>', '0')->orderBy('lname', 'asc')->lists('full_name', 'id');
		$subordinates = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))->where('level_id', '=', '0')->orderBy('lname', 'asc')->lists('full_name', 'id');
		$employs = DB::table('employs')->get();
		return View::make('hierarchies.create')
			->with('levels', $levels)
			->with('supervisors', $supervisors)
			->with('employs',$employs)
			->with('subordinates', $subordinates);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$input = Input::all();
		$validation = Validator::make($input, Hierarchy::$rules);

		$hierarchy_id = DB::table('hierarchies')->max('id');
		$hierarchy_id = $hierarchy_id + 1;

		if ($validation->passes())
		{
			$hierarchy = new Hierarchy;
			$hierarchy->hierarchy_name = Input::get('hierarchy_name');
			$hierarchy->supervisor_id = Input::get('supervisor_id');
			$hierarchy->description = Input::get('description');

			$subordinates = Input::get('subordinates');

			foreach ($subordinates as $subordinate) {	
				DB::table('hierarchy_subordinates')->insert(array(
					array('hierarchy_id' => $hierarchy_id, 'employee_id' => $subordinate)
				));
			}
				
			$hierarchy->save();

			return Redirect::route('hierarchies.index');
		}

		return Redirect::route('hierarchies.index')
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
		$hierarchy = $this->hierarchy->findOrFail($id);

		$employees = DB::table('hierarchy_subordinates')->where('hierarchy_id', '=', $hierarchy->id)->get();
		$employee_lists = array();
		$supervisors = Employ::select(DB::raw('concat(lname, ", ", fname, "- ", name) as full_name'), 'employs.id' )
		->join('levels', 'level_id', '=', 'levels.id')
		->join('hierarchies', 'employs.id', '=', 'hierarchies.supervisor_id')
		->where('level_id', '>', '0')->where('employs.id', '=', $hierarchy->supervisor_id)
		->orderBy('lname', 'asc')->lists('full_name', 'id');
		$new_subordinates = Employ::select(DB::raw('concat (lname, ", ", fname) as full_name, id'))
			 ->whereNotExists(function($query)
            {
                $query->select(DB::raw('employee_id'))
                      ->from('hierarchy_subordinates')
                      ->whereRaw('hierarchy_subordinates.employee_id = employs.id');
            })
			->where('level_id', '=', '0')
			->orderBy('lname', 'asc')
			->lists('full_name', 'id');
		foreach ($employees as $employee) {
			$subordinates = DB::table('departments')->join('employs','departments.id' , '=', 'employs.department_id')->where('employs.id', '=', $employee->employee_id)->get();			
			array_push($employee_lists, $subordinates);
		}
		sort($employee_lists);

		return View::make('hierarchies.show', compact('hierarchy'))
		->with('employee_lists', $employee_lists)
		->with('supervisors', $supervisors)
		->with('new_subordinates', $new_subordinates);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$hierarchy = $this->hierarchy->find($id);

		if (is_null($hierarchy))
		{
			return Redirect::route('hierarchies.index');
		}

		return View::make('hierarchies.edit', compact('hierarchy'));
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
		$validation = Validator::make($input, Hierarchy::$rules);

		if ($validation->passes())
		{
			$hierarchy = $this->hierarchy->find($id);
			$hierarchy->update($input);

			return Redirect::route('hierarchies.show', $id);
		}

		return Redirect::route('hierarchies.edit', $id)
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
		$this->hierarchy->find($id)->delete();

		return Redirect::route('hierarchies.index');
	}

	public function assignSubordinates()
	{
		$hierarchies = ['Select a hierarchy...'] + DB::table('hierarchies')->lists('hierarchy_name', 'id');
		$employs=DB::table('employs')
		->where('status','!=','Inactive')
		->where('status','!=','Terminated')
		 ->whereNotExists(function($query)
            {
                $query->select(DB::raw('employee_id'))
                      ->from('hierarchy_subordinates')
                      ->whereRaw('hierarchy_subordinates.employee_id = employs.id');
            })
		 ->where('level_id', '=', '0')->get();
		$hierarchy_subordinates = DB::table('hierarchy_subordinates')->get();
		$hierarchy_employs = DB::table('employs')->get();
		$departments = DB::table('departments')->get();
		$is_post = 'false';
		$supervisors = Employ::select(DB::raw('concat(lname, ", ", fname) as full_name'), 'id' )->where('level_id', '>', '0')->orderBy('lname', 'asc')->lists('full_name', 'id');
		return View::make('hierarchies.assign')
			->with('hierarchies', $hierarchies)
			->with('employs', $employs)
			->with('is_post', $is_post)
			->with('departments', $departments)
			->with('hierarchy_subordinates', $hierarchy_subordinates)
			->with('hierarchy_employs', $hierarchy_employs)
			->with('supervisors', $supervisors);
	}

	public function postAssignSubordinates()
	{
		$hierarchy_id = Input::get('hierarchy_id');
		$hierarchies = ['Select a hierarchy...'] + DB::table('hierarchies')->lists('hierarchy_name', 'id');
		$employs=DB::table('employs')
		->where('status','!=','Inactive')
		->where('status','!=','Terminated')
		->whereNotExists(function($query)
            {
                $query->select(DB::raw('employee_id'))
                      ->from('hierarchy_subordinates')
                      ->whereRaw('hierarchy_subordinates.employee_id = employs.id');
            })
		 ->where('level_id', '=', '0')->get();
		$hierarchy_subordinates = DB::table('hierarchy_subordinates')->where('hierarchy_id', '=', $hierarchy_id)->get();
		$hierarchy_employs = DB::table('employs')->get();
		$departments = DB::table('departments')->get();
		$is_post = 'true';
		$supervisors = Employ::select(DB::raw('concat(lname, ", ", fname) as full_name'), 'id' )->where('level_id', '>', '0')->orderBy('lname', 'asc')->lists('full_name', 'id');
		return View::make('hierarchies.assign')
			->with('hierarchies', $hierarchies)
			->with('employs', $employs)
			->with('is_post', $is_post)
			->with('departments', $departments)
			->with('hierarchy_subordinates', $hierarchy_subordinates)
			->with('hierarchy_employs', $hierarchy_employs)
			->with('supervisors', $supervisors)
			->with('hierarchy_id', $hierarchy_id);	
	}

	public function addExtraSubordinates()
	{
		$hierarchy_id = Input::get('hierarchy_id');
		$new_subordinates = Input::get('new_subordinates');

			foreach ($new_subordinates as $new_subordinate) {	
				DB::table('hierarchy_subordinates')->insert(array(
					array('hierarchy_id' => $hierarchy_id, 'employee_id' => $new_subordinate)
				));
			}
				
			return Redirect::route('hierarchies.show');
	}

	public function addSubordinates()
	{
		$hierarchy_id = Input::get('hierarchy_id');
		$employs = DB::table('employs')->get();

			foreach ($employs as $employ) {
				$id = DB::table('hierarchy_subordinates')->max('id');
				if (Input::has($employ->id)) {
					//Save here
					$employee_id = Input::get($employ->id);
					$id = $id + 1;
					DB::table('hierarchy_subordinates')->insert(array(
						array('id' => $id, 'hierarchy_id' => $hierarchy_id, 'employee_id' => $employee_id)
				));
				}
			}
				
			$hierarchy_id = Input::get('hierarchy_id');
		$hierarchies = ['Select a hierarchy...'] + DB::table('hierarchies')->lists('hierarchy_name', 'id');
		$employs=DB::table('employs')
		->whereNotExists(function($query)
            {
                $query->select(DB::raw('employee_id'))
                      ->from('hierarchy_subordinates')
                      ->whereRaw('hierarchy_subordinates.employee_id = employs.id');
            })
		 ->where('level_id', '=', '0')->get();
		$hierarchy_subordinates = DB::table('hierarchy_subordinates')->where('hierarchy_id', '=', $hierarchy_id)->get();
		$hierarchy_employs = DB::table('employs')->get();
		$departments = DB::table('departments')->get();
		$is_post = 'true';
		$supervisors = Employ::select(DB::raw('concat(lname, ", ", fname) as full_name'), 'id' )->where('level_id', '>', '0')->orderBy('lname', 'asc')->lists('full_name', 'id');
		return View::make('hierarchies.assign')
			->with('hierarchies', $hierarchies)
			->with('employs', $employs)
			->with('is_post', $is_post)
			->with('departments', $departments)
			->with('hierarchy_subordinates', $hierarchy_subordinates)
			->with('hierarchy_employs', $hierarchy_employs)
			->with('supervisors', $supervisors)
			->with('hierarchy_id', $hierarchy_id);	
	}


	public function removeSubordinates()
	{
		$hierarchy_id = Input::get('hierarchy_id');
		$hierarchy_subordinates = DB::table('hierarchy_subordinates')->get();			
		
			foreach ($hierarchy_subordinates as $sub) {
			
				if (Input::has($sub->employee_id)) {
					//Save here
					$employee_id = Input::get($sub->employee_id);

					DB::table('hierarchy_subordinates')->where('employee_id', '=', $employee_id)->delete();
				}
			
		}		
			$hierarchy_id = Input::get('hierarchy_id');
		$hierarchies = ['Select a hierarchy...'] + DB::table('hierarchies')->lists('hierarchy_name', 'id');
		$employs=DB::table('employs')
		->whereNotExists(function($query)
            {
                $query->select(DB::raw('employee_id'))
                      ->from('hierarchy_subordinates')
                      ->whereRaw('hierarchy_subordinates.employee_id = employs.id');
            })
		 ->where('level_id', '=', '0')->get();
		$hierarchy_subordinates = DB::table('hierarchy_subordinates')->where('hierarchy_id', '=', $hierarchy_id)->get();
		$hierarchy_employs = DB::table('employs')->get();
		$departments = DB::table('departments')->get();
		$is_post = 'true';
		$supervisors = Employ::select(DB::raw('concat(lname, ", ", fname) as full_name'), 'id' )->where('level_id', '>', '0')->orderBy('lname', 'asc')->lists('full_name', 'id');
		return View::make('hierarchies.assign')
			->with('hierarchies', $hierarchies)
			->with('employs', $employs)
			->with('is_post', $is_post)
			->with('departments', $departments)
			->with('hierarchy_subordinates', $hierarchy_subordinates)
			->with('hierarchy_employs', $hierarchy_employs)
			->with('supervisors', $supervisors)
			->with('hierarchy_id', $hierarchy_id);	
	}


	public function removeSubordinate()
	{
		$hierarchy_id = Input::get('hierarchy_id');
		$employee_id = Input::get('employee_id');

			DB::table('hierarchy_subordinates')
				->where('hierarchy_id', '=', $hierarchy_id)
				->where('employee_id', '=', $employee_id)
				->delete();
				
			return Redirect::route('hierarchies.show');
	}

}
