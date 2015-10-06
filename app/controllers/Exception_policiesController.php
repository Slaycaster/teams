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

	public function postAdd()
	{
		$exception_policies = $this->exception_policy->all();
		$exception_group = Exception_group::paginate(9);
		$exception_groups=DB::table('exception_groups')->get();
		$exception_id = Input::get('id');
		$assign_exceptions=DB::table('assign_exceptions')->get();	
		return View::make('exception_policies.exception_add')
		->with('exception_groups',$exception_groups)
		->with('exception_group',$exception_group)
		->with('exception_policies',$exception_policies)
		->with('assign_exceptions',$assign_exceptions)
		->with('exception_id',$exception_id)
		;

	}

	public function postInsert()
	{
	
		
		$exception_policies = DB::table('exception_policies')->get();
		$exception_id = Input::get('group_id');
			foreach ($exception_policies as $value) {
					
						$check = Input::get($value->id);
						$search = $this->exception_policy->find($check);
					$counter = DB::table('assign_exceptions')->where('group_id', '=', $exception_id)
					->where('exception_id', '=', Input::get($value->id))->get();	
				
					if ($check and $counter == null) {

						DB::table('assign_exceptions')->insert(
						array('group_id' => $exception_id, 'exception_id' => Input::get($value->id), 
								'severity' => Input::get($value->id.'exception_severity'),
								'grace' =>Input::get($value->id.'exception_grace'),
								'watch_window' => Input::get($value->id.'exception_watchwindow'),
								'email_notification' => Input::get($value->id.'exception_emailnotification'))
						);
					}

			}
		
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

	public function postEdit()
	{
		$id = Input::get('id');
		$exception_policy = $this->exception_policy->find($id);
		$exception_groups = DB::table('assign_exceptions')->where('group_id', '=', $exception_policy->id)->get();
		$exceptions_lists = array();
		$groups = array(); 

		$is_active = Input::get('is_active');
		$exception_name = Input::get('exception_name');
		
        $severity = Input::get('severity');
		$grace = Input::get('grace');
		$watch_window = Input::get('watch_window');
		$email_notification = Input::get('email_notification');
        
		$exception_id = Input::get('exception_id');
		DB::statement('UPDATE assign_exceptions SET severity=:sev, grace=:gra, watch_window=:wat, email_notification=:ema WHERE group_id=:res2 AND exception_id=:exp',
		array('sev' => $severity,'gra' => $grace, 'wat' => $watch_window, 'ema' => $email_notification, 'res2' => $id, 'exp' =>$exception_id) );

		foreach ($exception_groups as $exception_group) {
			$exceptions = DB::table('exception_policies')->where('id', '=', $exception_group->exception_id)->get();
			$exception_data = DB::table('exception_groups')->where('id', '=', $exception_group->group_id)->get();
			array_push($exceptions_lists, $exceptions);
			array_push($groups, $exception_data);
		}

		if (is_null($exception_policy))
		{
			return Redirect::route('exception_policies.index');
		}

		return View::make('exception_policies.edit', compact('exception_policy'))
		->with('exception_groups', $exception_groups)
			->with('exceptions_lists', $exceptions_lists)
			->with('groups',$groups);
	
	}

	public function postDelete()
	{
		$id = Input::get('id');
		$exception_policy = $this->exception_policy->find($id);
		$exception_groups = DB::table('assign_exceptions')->where('group_id', '=', $exception_policy->id)->get();
		$exceptions_lists = array();
		$groups = array(); 

		$is_active = Input::get('is_active');
		$exception_name = Input::get('exception_name');
		
        $severity = Input::get('severity');
		$grace = Input::get('grace');
		$watch_window = Input::get('watch_window');
		$email_notification = Input::get('email_notification');
        
		$exception_id = Input::get('exception_id');
		DB::statement('DELETE from assign_exceptions WHERE group_id=:res2 AND exception_id=:exp',
		array('res2' => $id, 'exp' =>$exception_id) );

		foreach ($exception_groups as $exception_group) {
			$exceptions = DB::table('exception_policies')->where('id', '=', $exception_group->exception_id)->get();
			$exception_data = DB::table('exception_groups')->where('id', '=', $exception_group->group_id)->get();
			array_push($exceptions_lists, $exceptions);
			array_push($groups, $exception_data);
		}

		if (is_null($exception_policy))
		{
			return Redirect::route('exception_policies.index');
		}

		return View::make('exception_policies.edit', compact('exception_policy'))
		->with('exception_groups', $exception_groups)
			->with('exceptions_lists', $exceptions_lists)
			->with('groups',$groups);
	
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
			$exception->save();
			$exception_id = DB::table('exception_groups')->max('id');
			foreach ($exception_policies as $key => $value) {
					
						$check = Input::get($value->id);
						$search = $this->exception_policy->find($check);
						
				
					if ($check) {

						DB::table('assign_exceptions')->insert(array(
						array('group_id' => $exception_id, 'exception_id' => Input::get($value->id), 
							'severity' => Input::get($value->id.'exception_severity'),
								'grace' =>Input::get($value->id.'exception_grace'),
								'watch_window' => Input::get($value->id.'exception_watchwindow'),
								'email_notification' => Input::get($value->id.'exception_emailnotification')))
						);
					}

			}
		
				

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
		$exception_groups = DB::table('assign_exceptions')->where('group_id', '=', $exception_policy->id)->get();
		$exceptions_lists = array();
		$groups = array(); 
		foreach ($exception_groups as $exception_group) {
			$exceptions = DB::table('exception_policies')->where('id', '=', $exception_group->exception_id)->get();
			$exception_data = DB::table('exception_groups')->where('id', '=', $exception_group->group_id)->get();
			array_push($exceptions_lists, $exceptions);
			array_push($groups, $exception_data);
		}

		if (is_null($exception_policy))
		{
			return Redirect::route('exception_policies.index');
		}

		return View::make('exception_policies.edit', compact('exception_policy'))
		->with('exception_groups', $exception_groups)
			->with('exceptions_lists', $exceptions_lists)
			->with('groups',$groups);
	}

	public function postUpdate()
	{
		$id = Input::get('id');
		$group_name = Input::get('exceptiongroup_name');
		$description = Input::get('description');

		DB::statement('UPDATE exception_groups SET exceptiongroup_name=:sur, description=:des WHERE id=:res2',
			array('sur' => $group_name,'des' => $description, 'res2' => $id) );

		$exception_policy = $this->exception_policy->find($id);
		$exception_groups = DB::table('assign_exceptions')->where('group_id', '=', $exception_policy->id)->get();
		$exceptions_lists = array();
		$groups = array(); 
		foreach ($exception_groups as $exception_group) {
			$exceptions = DB::table('exception_policies')->where('id', '=', $exception_group->exception_id)->get();
			$exception_data = DB::table('exception_groups')->where('id', '=', $exception_group->group_id)->get();
			array_push($exceptions_lists, $exceptions);
			array_push($groups, $exception_data);
		}

		if (is_null($exception_policy))
		{
			return Redirect::route('exception_policies.index');
		}

		return View::make('exception_policies.edit', compact('exception_policy'))
		->with('exception_groups', $exception_groups)
			->with('exceptions_lists', $exceptions_lists)
			->with('groups',$groups);

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
