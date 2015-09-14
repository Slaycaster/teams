<?php

class Exception_policiesController extends BaseController {

	/**
	 * Exception_policy Repository
	 *
	 * @var Exception_policy
	 */
	protected $exception_policy;

	public function __construct(Exception_policy $exception_policy)
	{
		$this->exception_policy = $exception_policy;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$exception_policies = $this->exception_policy->all();
		$exception_group = Exception_group::paginate(9);
		$exception_groups=DB::table('exception_groups')->get();
		$assign_exceptions=DB::table('assign_exceptions')->get();	
		return View::make('exception_policies.index', compact('exception_policies'))
		->with('exception_groups',$exception_groups)
		->with('exception_group',$exception_group)
		->with('exception_policies',$exception_policies)
		->with('assign_exceptions',$assign_exceptions);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$exception_policies = $this->exception_policy->all();
		$exception_groups=DB::table('exception_groups')->get();
		$assign_exceptions=DB::table('assign_exceptions')->get();
		return View::make('exception_policies.create')
		->with('exception_groups',$exception_groups)
		->with('exception_policies',$exception_policies)
		->with('assign_exceptions',$assign_exceptions);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

	
	public function store()
	{

		$input = Input::all();
		$validation = Validator::make($input, Exception_group::$rules);

		if ($validation->passes())
		{

			$exception_policies = DB::table('exception_policies')->get();
			$exception = new Exception_group;
			$exception->exceptiongroup_name = Input::get('exceptiongroup_name');
			$exception->description = Input::get('description');
			$exception_id = DB::table('exception_groups')->max('id');
			$exception_id = $exception_id + 1;
			foreach ($exception_policies as $key => $value) {
					
						$check = Input::get($value->id);
						$search = $this->exception_policy->find($check);

					if ($check) {
						DB::table('assign_exceptions')->insert(array(
						array('group_id' => $exception_id, 'exception_id' => Input::get($value->id), 
							'severity' => Input::get($value->id.'exception_severity'),
								'grace' => Input::get($value->id.'exception_grace'),
								'watch_window' => Input::get($value->id.'exception_watchwindow'),
								'email_notification' => Input::get($value->id.'exception_emailnotification')))
						);
					}

			}
			$exception->save();
				

			return Redirect::route('exception_policies.index');
		}

		return Redirect::route('exception_policies.index')
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
		$exception_policy = $this->exception_policy->findOrFail($id);
		$exception_groups = DB::table('assign_exceptions')->where('group_id', '=', $exception_policy->id)->get();
		$exceptions_lists = array();
		$groups = array(); 
		foreach ($exception_groups as $exception_group) {
			$exceptions = DB::table('exception_policies')->where('id', '=', $exception_group->exception_id)->get();
			$exception_data = DB::table('exception_groups')->where('id', '=', $exception_group->group_id)->get();
			array_push($exceptions_lists, $exceptions);
			array_push($groups, $exception_data);
		}
		return View::make('exception_policies.show', compact('exception_policy'))
			->with('exception_groups', $exception_groups)
			->with('exceptions_lists', $exceptions_lists)
			->with('groups',$groups);

		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$exception_policy = $this->exception_policy->find($id);

		if (is_null($exception_policy))
		{
			return Redirect::route('exception_policies.index');
		}

		return View::make('exception_policies.edit', compact('exception_policy'));
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
		$validation = Validator::make($input, Exception_policy::$rules);

		if ($validation->passes())
		{
			$exception_policy = $this->exception_policy->find($id);
			$exception_policy->update($input);

			return Redirect::route('exception_policies.index', $id);
		}

		return Redirect::route('exception_policies.index', $id)
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
		$this->exception_policy->find($id)->delete();

		return Redirect::route('exception_policies.index');
	}

}
